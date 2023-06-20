<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_bot}}`.
 */
class m230323_200425_create_telegram_bot_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_bot}}', [
            'id' => $this->primaryKey(),
            'bot_id'=> $this->string(),
            'chat_id'=> $this->string(),
            'date'=> $this->string(),
            'name'=> $this->string(),
            'active'=> "enum('0','1') NOT NULL DEFAULT '1'"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_bot}}');
    }
}
