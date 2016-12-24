<?php

use yii\db\Migration;

/**
 * Handles the creation of table `backups`.
 */
class m161214_202029_create_backups_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('backups', [
            'id' => $this->primaryKey()->unsigned(),
            'repository_id' => $this->integer()->unsigned()->notNull(),
            'time' => $this->integer(11)->unsigned()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('backups');
    }
}
