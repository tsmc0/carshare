<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250314_032510_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'first_name' => $this->string(255)->notNull(),
            'second_name' => $this->string(255)->notNull(),
            'father_name' => $this->string(255)->null(),
            'passport' => $this->string(255)->null(),
            'drive_license' => $this->string(255)->null(),
            'email' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'phone_number' => $this->string(25)->null(),
            'is_verified' => $this->tinyInteger(1)->notNull()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-user-user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-user_id',
            'user'
        );

        $this->dropTable('{{%user}}');
    }
}
