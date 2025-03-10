<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auto_brand}}`.
 */
class m250314_033713_create_auto_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auto_brand}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
        ]);

        $this->createIndex(
            'idx-id-auto_br_id',
            'auto_brand',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-id-auto_br_id',
            'auto_brand'
        );

        $this->dropTable('{{%auto_brand}}');
    }
}
