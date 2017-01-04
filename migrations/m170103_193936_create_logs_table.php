<?php

use yii\db\Migration;

/**
 * Handles the creation of table `logs`.
 */
class m170103_193936_create_logs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('logs', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned()->notNull(),
            'action' => $this->string()->notNull(),
            'time' => $this->integer(11)->unsigned()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('logs');
    }
}
