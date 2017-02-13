<?php

use yii\db\Migration;

class m170210_135846_data extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%data}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'resource' => $this->string(255),
            'amount' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('user_id', '{{%data}}', 'user_id');
    }

    public function down()
    {
        $this->dropTable('{{%data}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
