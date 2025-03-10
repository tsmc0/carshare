<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auto}}`.
 */
class m250314_032711_create_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auto}}', [
            'id' => $this->primaryKey(),
            'public_id' => $this->string(255)->notNull(),
            'mark' => $this->string(255)->notNull(),
            'model' => $this->string(255)->notNull(),
            'coast_per_hour' => $this->string(255)->notNull(),
            'preview' => $this->text()->null(),
            'date_create' => $this->integer()->notNull(),
            'owner' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-owner-owner_id',
            'auto',
            'owner'
        );

        $this->addForeignKey(
            'fk-auto-owner_id',
            'auto',
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
            'fk-auto-owner_id',
            'auto'
        );

        $this->dropIndex(
            'idx-owner-owner_id',
            'auto'
        );

        $this->dropTable('{{%auto}}');
    }
}
