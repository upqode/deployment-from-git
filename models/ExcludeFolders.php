<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "exclude_folders".
 *
 * @property integer $id
 * @property integer $repository_id
 * @property string  $folder
 *
 * @property Repositories $repository
 */
class ExcludeFolders extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exclude_folders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repository_id', 'folder'], 'required'],
            [['repository_id'], 'integer'],
            [['folder'], 'string', 'max' => 255],
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
            'folder' => 'Folder',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepository()
    {
        return $this->hasOne(Repositories::className(), ['id' => 'repository_id']);
    }

}
