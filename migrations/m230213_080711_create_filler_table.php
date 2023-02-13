<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%filler}}`.
 */
class m230213_080711_create_filler_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%filler}}', [
            'id' => $this->primaryKey(),
            'id_file' => $this->integer()->notNull()->comment('File'),
            'fio' => $this->string()->notNull()->comment('Full Name'),
            'inn' => $this->string()->notNull()->comment('INN'),
            'phone' => $this->string()->notNull()->comment('Phone Number'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
        ]);

        $this->addForeignKey(
            'fk-filler-id_file',
            'filler',
            'id_file',
            'file',
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
            'fk-filler-id_file',
            'filler'
        );

        $this->dropTable('{{%filler}}');
    }
}
