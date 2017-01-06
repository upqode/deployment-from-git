<?php

use app\models\Settings;
use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m170106_084354_create_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('settings', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(50)->notNull(),
            'value' => $this->string(255)->notNull(),
        ]);

        // create default params
        $this->batchInsert(Settings::tableName(), ['name', 'value'], [
            [Settings::SETTING_ADMIN_EMAIL, 'admin@example.com'],
            [Settings::SETTING_BACKUPS_DIR, '@runtime/backups'],
            [Settings::SETTING_BACKUPS_MAX_COUNT_COPY, 25],
            [Settings::SETTING_REMOVE_LOGS_AFTER_DAYS, 10],
            [Settings::SETTING_SHOW_ELEMENTS_ON_PAGE, 50],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('settings');
    }
}
