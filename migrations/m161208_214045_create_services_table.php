<?php

use yii\db\Migration;

/**
 * Handles the creation of table `services`.
 */
class m161208_214045_create_services_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('services', [
            'id' => $this->primaryKey()->unsigned(),
            'type' => $this->smallInteger(1)->notNull()->unsigned(),
            'username' => $this->string(50)->notNull(),
            'access_token' => $this->string(100)->notNull(),
            'created_date' => $this->integer(11)->unsigned()->notNull(),
            'is_active' => $this->boolean()->defaultValue(1)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('services');
    }
}
