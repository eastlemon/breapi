<?php

use yii\db\Migration;

class m211106_125415_init_user_tables extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'id_parent' => $this->integer()->comment('Parent User'),
            'username' => $this->string()->notNull()->unique()->comment('User Name'),
            'auth_key' => $this->string(32)->notNull()->comment('Auth Key'),
            'password_hash' => $this->string()->notNull()->comment('Password Hash'),
            'password_reset_token' => $this->string()->unique()->comment('Password Reset Token'),
            'email' => $this->string()->notNull()->unique()->comment('E-mail'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Status'),
            'created_at' => $this->integer()->notNull()->comment('Creation Time'),
            'updated_at' => $this->integer()->notNull()->comment('Updation Time'),
            'last_login' => $this->integer()->comment('Last Login Time'),
        ]);

        $this->addForeignKey(
            'fk-user-id_parent',
            'user',
            'id_parent',
            'user',
            'id',
            'CASCADE'
        );
    }
    
    public function safeDown(): void
    {
        $this->dropForeignKey(
            'fk-user-id_parent',
            'user'
        );

        $this->dropTable('{{%user}}');
    }
}
