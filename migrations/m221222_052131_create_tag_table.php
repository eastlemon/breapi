<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m221222_052131_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull()->comment('User Owner'),
            'name' => $this->string()->notNull()->comment('Tag'),
        ]);

        $this->addForeignKey(
            'fk-tag-id_user',
            'tag',
            'id_user',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-tag-id_user',
            'tag'
        );

        $this->dropTable('{{%tag}}');
    }
}
