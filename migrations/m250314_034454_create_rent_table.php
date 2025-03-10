<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rent}}`.
 */
class m250314_034454_create_rent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rent}}', [
            'id' => $this->primaryKey(),
            'user' => $this->integer()->notNull(),
            'auto' => $this->integer()->notNull(),
            'date_take' => $this->string(255)->notNull(),
            'long_in_hours' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-id-auto_rent_id',
            'rent',
            'id'
        );

        $this->createIndex(
            'idx-user-user_id',
            'rent',
            'user'
        );

        $this->addForeignKey(
            'fk-rent-user_id',
            'rent',
            'user',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-auto-auto_id',
            'rent',
            'auto'
        );

        $this->addForeignKey(
            'fk-rent-auto_id',
            'rent',
            'auto',
            'auto',
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
            'fk-rent-user_id',
            'rent'
        );

        $this->dropIndex(
            'idx-user-user_id',
            'rent'
        );

        $this->dropForeignKey(
            'fk-rent-auto_id',
            'rent'
        );

        $this->dropIndex(
            'idx-auto-auto_id',
            'rent'
        );

        $this->dropIndex(
            'idx-id-auto_rent_id',
            'rent'
        );

        $this->dropTable('{{%rent}}');
    }
}
