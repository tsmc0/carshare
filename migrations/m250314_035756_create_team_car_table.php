<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%team_car}}`.
 */
class m250314_035756_create_team_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%team_car}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'auto' => $this->integer()->notNull(),
            'team' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-id-team_car_id',
            'team_car',
            'id'
        );

        $this->createIndex(
            'idx-user-user_id',
            'team_car',
            'user'
        );

        $this->addForeignKey(
            'fk-user-user_id',
            'team_car',
            'user',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-auto-auto_id',
            'team_car',
            'auto'
        );

        $this->addForeignKey(
            'fk-auto-auto_id',
            'team_car',
            'auto',
            'auto',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-team-team_id',
            'team_car',
            'team'
        );

        $this->addForeignKey(
            'fk-team-team_id',
            'team_car',
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
            'fk-team-team_id',
            'auto_car'
        );

        $this->dropIndex(
            'idx-team-team_id',
            'auto_car'
        );

        $this->dropForeignKey(
            'fk-auto-auto_id',
            'auto_car'
        );

        $this->dropIndex(
            'idx-auto-auto_id',
            'auto_car'
        );

        $this->dropForeignKey(
            'fk-user-user_id',
            'auto_car'
        );

        $this->dropIndex(
            'idx-user-user_id',
            'auto_car'
        );

        $this->dropIndex('idx-id-team_car_id', 'team_car');

        $this->dropTable('{{%team_car}}');
    }
}
