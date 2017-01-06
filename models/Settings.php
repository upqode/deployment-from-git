<?php

namespace app\models;

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
    const SETTING_ADMIN_EMAIL = 'admin_email';
    const SETTING_BACKUPS_DIR = 'backups_dir';
    const SETTING_SHOW_ELEMENTS_ON_PAGE = 'show_elements_on_page';
    const SETTING_REMOVE_LOGS_AFTER_DAYS = 'remove_logs_after_days';
    const SETTING_BACKUPS_MAX_COUNT_COPY = 'backups_max_count_copy';

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
        $value = Settings::find()->select('value')->where(['name' => $name])->asArray()->limit(1)->one();

        return ArrayHelper::getValue($value, 'value') ?: $default;
    }

}
