<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m230118_115954_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull()->comment('User Owner'),
            'name' => $this->string()->notNull()->comment('File Name'),
            'uniq_name' => $this->string()->notNull()->comment('File Unique Name'),
            'target' => $this->string()->notNull()->comment('File Target'),
            'ext' => $this->string()->notNull()->comment('File Extension'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
        ]);

        $this->addForeignKey(
            'fk-file-id_user',
            'file',
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
            'fk-file-id_user',
            'file'
        );

        $this->dropTable('{{%file}}');
    }
}
