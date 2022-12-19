<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requisite}}`.
 */
class m221216_110233_create_requisite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%requisite}}', [
            'id' => $this->primaryKey(),
            'id_agent' => $this->integer()->notNull()->comment('Agent'),
            'year' => $this->integer()->notNull()->comment('Year'),
            'full_name' => $this->text()->comment('Full Name'),
            'phone' => $this->string()->comment('Phone Number'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
            'is_del' => $this->tinyInteger()->comment('Delete Flag'),
        ]);

        $this->addForeignKey(
            'fk-requisite-id_agent',
            'requisite',
            'id_agent',
            'agent',
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
            'fk-requisite-id_agent',
            'requisite'
        );

        $this->dropTable('{{%requisite}}');
    }
}
