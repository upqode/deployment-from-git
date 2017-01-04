<?php

namespace app\models;

use app\components\FileSystem;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "backups".
 *
 * @property integer $id
 * @property integer $repository_id
 * @property integer $time
 *
 * @property Repositories $repository
 */
class Backups extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repository_id', 'time'], 'required'],
            [['repository_id', 'time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'repository_id' => 'Repository',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepository()
    {
        return $this->hasOne(Repositories::className(), ['id' => 'repository_id']);
    }

    /**
     * Get path to backup
     *
     * @param string $repository - remote path
     * @param integer $time
     * @return string
     */
    public function getBackupPath($repository, $time)
    {
        $dir = FileSystem::getRepositoryDir($repository);
        return $dir .'/'. date('d_m_Y_H_i_s', $time) .'.zip';
    }

    /**
     * Prepare for create backup and register log in db
     *
     * @param Repositories $repository
     * @return bool
     * @throws ErrorException
     */
    public static function createBackup(Repositories $repository)
    {
        @set_time_limit(100);
        $time = Yii::$app->formatter->asTimestamp('now');
        $backup_project_dir = FileSystem::getRepositoryDir($repository->remote_path);
        $filename = $backup_project_dir .'/'. date('d_m_Y_H_i_s', $time) .'.zip';

        // create folder for repository backup
        if (!file_exists($backup_project_dir)) {
            mkdir($backup_project_dir, 0777, true);
        }

        // create archive
        $create_zip = FileSystem::createZipArchive($filename, $repository->local_path);

        // check create archive
        if ($create_zip === 0) { // if local_path is empty
            return false;
        } elseif ($create_zip > 0) {
            $backup = new Backups([ // register backup log
                'repository_id' => $repository->id,
                'time' => $time,
            ]);

            Logs::setLog(401, [':repository' => $repository->remote_path]);

            return $backup->save();
        } else {
            throw new ErrorException('Backup archive is not created!');
        }
    }

    public function installBackup()
    {
        $file = $this->getBackupPath($this->repository->remote_path, $this->time);

        if (file_exists($file)) {
            $tmp_dir = str_replace('archives', 'tmp', $file);
            $tmp_dir = str_replace('.zip', '', $tmp_dir);

            // extract backup archive in tmp dir
            FileSystem::extractArchive($file, $tmp_dir);

            // clear previous version
            FileSystem::removeDir($this->repository->local_path, false);

            // copy new files
            FileSystem::copyFiles($tmp_dir, $this->repository->local_path);

            // remove tmp files
            FileSystem::removeDir($tmp_dir);

            // create log
            Logs::setLog(402, [':repository' => $this->repository->remote_path]);

            return true;
        }

        return false;
    }

    /**
     * Remove backup
     *
     * @return bool
     */
    public function deleteBackup()
    {
        $filename = $this->getBackupPath($this->repository->remote_path, $this->time);

        if ($this->delete()) {
            if (file_exists($filename)) {
                unlink($filename);
            }

            Logs::setLog(403, [':repository' => $this->repository->remote_path]);

            return true;
        }

        return false;
    }

}
