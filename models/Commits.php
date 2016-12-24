<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "commits".
 *
 * @property integer $id
 * @property integer $repository_id
 * @property string  $sha
 *
 * @property Repositories $repository
 */
class Commits extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repository_id', 'sha'], 'required'],
            [['repository_id'], 'integer'],
            [['sha'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'repository_id' => 'Repository ID',
            'sha' => 'Sha',
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
     * Save commit_sha after install
     *
     * @param integer $repository_id
     * @param string $commit_sha
     * @return bool|int
     */
    public static function saveInstalledCommitInfo($repository_id, $commit_sha)
    {
        $old_commit = self::findOne(['repository_id' => $repository_id]);

        if ($old_commit) {
            $old_commit->sha = $commit_sha;
            return $old_commit->update();
        } else {
            $new_commit = new self(['repository_id' => $repository_id, 'sha' => $commit_sha]);
            return $new_commit->save();
        }
    }

}
