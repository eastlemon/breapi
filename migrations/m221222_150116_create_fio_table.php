<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fio}}`.
 */
class m221222_150116_create_fio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fio}}', [
            'id' => $this->primaryKey(),
            'id_inn' => $this->integer()->notNull()->comment('INN'),
            'year' => $this->integer()->notNull()->comment('Year'),
            'fio' => $this->string()->notNull()->comment('Full Name'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
        ]);

        $this->addForeignKey(
            'fk-fio-id_inn',
            'fio',
            'id_inn',
            'inn',
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
            'fk-fio-id_inn',
            'fio'
        );

        $this->dropTable('{{%fio}}');
    }
}
