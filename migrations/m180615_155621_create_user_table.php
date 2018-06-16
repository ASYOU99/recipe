<?php

use app\migrations\Migration;


/**
 * Handles the creation of table `user`.
 */
class m180615_155621_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull()
        ], $this->tableOptions);

        $this->createIndex('username', '{{%user}}', 'username', true);
        $this->createIndex('email', '{{%user}}', 'email', true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
