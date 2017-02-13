<?php

use yii\db\Migration;

class m170208_135637_companies extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%companies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'quota' => $this->integer()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%companies}}');
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
