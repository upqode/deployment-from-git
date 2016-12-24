<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commits`.
 */
class m161224_161851_create_commits_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('commits', [
            'id' => $this->primaryKey()->unsigned(),
            'repository_id' => $this->integer()->unsigned()->notNull(),
            'sha' => $this->string(100)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('commits');
    }
}
