<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "repositories".
 *
 * @property integer $id
 * @property integer $service_id
 * @property string  $name
 * @property string  $local_path
 * @property string  $remote_path
 * @property boolean $has_auto_update
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
            [['service_id', 'name', 'local_path', 'remote_path'], 'required'],
            [['service_id'], 'integer'],
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
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }

}
