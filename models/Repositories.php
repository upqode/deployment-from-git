<?php

namespace app\models;

use app\components\BitBucket;
use app\components\GitHub;
use app\models\forms\ServiceForm;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "repositories".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $service_id
 * @property string  $name
 * @property string  $local_path
 * @property string  $remote_path
 * @property boolean $has_auto_update
 *
 * @property Users    $user
 * @property Commits  $commit
 * @property Services $service
 */
class Repositories extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repositories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'service_id', 'name', 'local_path', 'remote_path'], 'required'],
            [['user_id', 'service_id'], 'integer'],
            [['has_auto_update'], 'boolean'],
            [['name'], 'string', 'max' => 50],
            [['local_path', 'remote_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service',
            'name' => 'Name',
            'local_path' => 'Local Path',
            'remote_path' => 'Remote Path',
            'has_auto_update' => 'Has Auto Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommit()
    {
        return $this->hasOne(Commits::className(), ['repository_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }

    /**
     * Get status On|Off for auto update
     *
     * @return string
     */
    public function getAutoUpdateStatus()
    {
        return $this->has_auto_update ? 'On' : 'Off';
    }

    /**
     * Get repository commit
     *
     * @return array
     */
    public function getRepositoryCommits()
    {
        $commits = array();

        if ($this->service_id == ServiceForm::TYPE_GITHUB) {
            $commits = GitHub::getCommits($this);
        } elseif ($this->service_id == ServiceForm::TYPE_BITBUCKET) {
            $commits = BitBucket::getCommits($this);
        }

        return $commits;
    }

    /**
     * Get repository branches
     *
     * @param string $branch
     * @return array
     */
    public function getRepositoryBranches($branch = '')
    {
        $branches = array();

        if ($this->service_id == ServiceForm::TYPE_GITHUB) {
            $branches = GitHub::getBranches($this, $branch);
        } elseif ($this->service_id == ServiceForm::TYPE_BITBUCKET) {
            $branches = BitBucket::getBranches($this, $branch);
        }

        return $branches;
    }

    /**
     * Save archive from repository
     *
     * @param string $commit
     * @return bool|string
     * @throws ErrorException
     */
    public function saveRemoteArchive($commit)
    {
        if ($this->service_id == ServiceForm::TYPE_GITHUB) {
            return GitHub::saveArchive($this, $commit);
        } elseif ($this->service_id == ServiceForm::TYPE_BITBUCKET) {
            return BitBucket::saveArchive($this, $commit);
        }

        throw new ErrorException('Archive not download!');
    }

    /**
     * Check this repository on availability new version
     *
     * @return bool
     */
    public function hasNewVersion()
    {
        $remote_old_commit = null;
        $local_old_commit = Commits::find()->select('sha')->where(['repository_id' => $this->id])->one();
        $branch_info = $this->getRepositoryBranches('master');

        if ($this->service_id == ServiceForm::TYPE_GITHUB) {
            $remote_old_commit = ArrayHelper::getValue($branch_info, 'commit.sha');
        } elseif ($this->service_id == ServiceForm::TYPE_BITBUCKET) {
            $remote_old_commit = ArrayHelper::getValue($branch_info, 'target.hash');
        }

        return ($remote_old_commit != $local_old_commit['sha']) ? true : false;
    }

}
