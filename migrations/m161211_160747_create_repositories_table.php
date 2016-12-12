<?php

use yii\db\Migration;

/**
 * Handles the creation of table `repositories`.
 */
class m161211_160747_create_repositories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('repositories', [
            'id' => $this->primaryKey()->unsigned(),
            'service_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(50)->notNull(),
            'local_path' => $this->string(255)->notNull(),
            'remote_path' => $this->string(255)->notNull(),
            'has_auto_update' => $this->boolean()->defaultValue(0)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('repositories');
    }
}
