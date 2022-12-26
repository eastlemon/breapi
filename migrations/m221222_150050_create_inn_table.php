<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inn}}`.
 */
class m221222_150050_create_inn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inn}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull()->comment('User Owner'),
            'id_tag' => $this->integer()->notNull()->comment('Tag'),
            'inn' => $this->string()->notNull()->comment('INN'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
        ]);

        $this->addForeignKey(
            'fk-inn-id_user',
            'inn',
            'id_user',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-inn-id_tag',
            'inn',
            'id_tag',
            'tag',
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
            'fk-inn-id_user',
            'inn'
        );

        $this->dropForeignKey(
            'fk-inn-id_tag',
            'inn'
        );

        $this->dropTable('{{%inn}}');
    }
}
