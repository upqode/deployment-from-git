<?php

namespace app\models\forms;

use app\models\Settings;
use yii\base\Model;

class SettingsForm extends Model
{
    public $admin_email;
    public $backups_dir;
    public $show_elements_on_page;
    public $remove_logs_after_days;
    public $backups_max_count_copy;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['admin_email'], 'email'],
            [['backups_dir', 'show_elements_on_page'], 'string', 'max' => 255],
            [['remove_logs_after_days', 'backups_max_count_copy'], 'string', 'max' => 255],
        ];
    }

    /**
     * Update system options
     *
     * @return bool
     */
    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        Settings::updateAll(['value' => $this->admin_email], ['name' => Settings::SETTING_ADMIN_EMAIL]);
        Settings::updateAll(['value' => $this->backups_dir], ['name' => Settings::SETTING_BACKUPS_DIR]);
        Settings::updateAll(['value' => $this->show_elements_on_page], ['name' => Settings::SETTING_SHOW_ELEMENTS_ON_PAGE]);
        Settings::updateAll(['value' => $this->remove_logs_after_days], ['name' => Settings::SETTING_REMOVE_LOGS_AFTER_DAYS]);
        Settings::updateAll(['value' => $this->backups_max_count_copy], ['name' => Settings::SETTING_BACKUPS_MAX_COUNT_COPY]);

        return true;
    }

}