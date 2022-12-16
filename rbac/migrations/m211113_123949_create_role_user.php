<?php

use yii2mod\rbac\migrations\Migration;

class m211113_123949_create_role_user extends Migration
{
    public function safeUp(): void
    {
        $this->createRole('user', 'User belongs to the administrator\'s cabinet. Can see his load sheet and make calls.');
    }

    public function safeDown(): bool
    {
        echo "m211113_123949_create_role_user cannot be reverted.\n";

        $this->removeRole('user');

        return false;
    }
}