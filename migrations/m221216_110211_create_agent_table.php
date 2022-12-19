<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%agent}}`.
 */
class m221216_110211_create_agent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%agent}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull()->comment('User Owner'),
            'inn' => $this->string()->notNull()->comment('INN'),
            'created_at' => $this->dateTime()->comment('Creation Time'),
            'updated_at' => $this->dateTime()->comment('Updation Time'),
            'is_del' => $this->tinyInteger()->comment('Delete Flag'),
        ]);

        $this->addForeignKey(
            'fk-agent-id_user',
            'agent',
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
            'fk-agent-id_user',
            'agent'
        );

        $this->dropTable('{{%agent}}');
    }
}
