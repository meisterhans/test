<?php

use yii\db\Migration;

class m170209_124409_users extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'name' => $this->string(255),
            'email' => $this->string(255)
        ], $tableOptions);

        $this->createIndex('company_id', '{{%users}}', 'company_id');
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
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
