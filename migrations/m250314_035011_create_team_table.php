<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team}}`.
 */
class m250314_035011_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'public_id' => $this->string(255)->notNull(),
            'owner' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-id-team_id_id',
            'team',
            'id'
        );

        $this->createIndex(
            'idx-user-owner_id',
            'team',
            'owner'
        );

        $this->addForeignKey(
            'fk-team-owner_id',
            'team',
            'owner',
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
            'fk-team-owner_id',
            'team'
        );

        $this->dropIndex(
            'idx-user-owner_id',
            'rent'
        );

        $this->dropIndex('idx-id-team_id_id', 'team');

        $this->dropTable('{{%team}}');
    }
}
