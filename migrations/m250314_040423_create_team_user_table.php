<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team_user}}`.
 */
class m250314_040423_create_team_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team_user}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'team' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-id-team_user_id',
            'team_user',
            'id'
        );

        $this->createIndex(
            'idx-team_user-user_id',
            'team_user',
            'user'
        );

        $this->addForeignKey(
            'fk-team_user-user_id',
            'team_user',
            'user',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-team_team_id',
            'team_user',
            'team'
        );

        $this->addForeignKey(
            'fk-team_user-team_id',
            'team_user',
            'team',
            'team',
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
            'fk-team_user-team_id',
            'team_user'
        );

        $this->dropIndex(
            'idx-team_team_id',
            'team_user'
        );

        $this->dropForeignKey(
            'fk-team_user-user_id',
            'team_user'
        );

        $this->dropIndex(
            'idx-team_user-user_id',
            'team_user'
        );

        $this->dropIndex('idx-id-team_user_id', 'team_user');

        $this->dropTable('{{%team_user}}');
    }
}
