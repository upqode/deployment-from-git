<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m161126_215802_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey()->unsigned(),
            'email' => $this->string(100)->unique()->notNull(),
            'password' => $this->string(60)->notNull(),
            'auth_key' => $this->string(15)->notNull(),
            'reset_key' => $this->string(15)->null(),
            'is_admin' => $this->boolean()->defaultValue(0)->notNull(),
            'has_create' => $this->boolean()->defaultValue(0)->notNull(),
            'has_edit' => $this->boolean()->defaultValue(0)->notNull(),
            'has_delete' => $this->boolean()->defaultValue(0)->notNull(),
            'has_update' => $this->boolean()->defaultValue(0)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
