<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exclude_folders`.
 */
class m170107_123225_create_exclude_folders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('exclude_folders', [
            'id' => $this->primaryKey()->unsigned(),
            'repository_id' => $this->integer()->unsigned()->notNull(),
            'folder' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('exclude_folders');
    }
}
