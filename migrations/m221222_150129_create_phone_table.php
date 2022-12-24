<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%phone}}`.
 */
class m221222_150129_create_phone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%phone}}', [
            'id' => $this->primaryKey(),
            'id_inn' => $this->integer()->notNull()->comment('INN'),
            'year' => $this->integer()->notNull()->comment('Year'),
            'phone' => $this->string()->notNull()->comment('Phone Number'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
        ]);

        $this->addForeignKey(
            'fk-phone-id_inn',
            'phone',
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
            'fk-phone-id_inn',
            'phone'
        );

        $this->dropTable('{{%phone}}');
    }
}
