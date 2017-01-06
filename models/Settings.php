<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Settings extends ActiveRecord
{
    const SETTING_ADMIN_EMAIL = 'adminEmail';
    const SETTING_BACKUPS_DIR = 'backupsDir';
    const SETTING_SHOW_ELEMENTS_ON_PAGE = 'showElementsOnPage';
    const SETTING_BACKUPS_MAX_COUNT_COPY = 'backupsMaxCountCopy';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * Get setting value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public static function getSettingValue($name, $default = null)
    {
        $value_from_db = Settings::find()->select('value')->where(['name' => $name])->asArray()->one();
        $value = ArrayHelper::getValue($value_from_db, 'value') ?: ArrayHelper::getValue(Yii::$app->params, $name);

        return $value ?: $default;
    }

}
