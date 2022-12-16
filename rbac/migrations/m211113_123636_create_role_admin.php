<?php

use yii2mod\rbac\migrations\Migration;

class m211113_123636_create_role_admin extends Migration
{
    public function safeUp(): void
    {
        $this->createRole('admin', 'Admin has all available permissions.');
    }

    public function safeDown(): bool
    {
        echo "m211113_123636_create_role_admin cannot be reverted.\n";

        $this->removeRole('admin');

        return false;
    }
}