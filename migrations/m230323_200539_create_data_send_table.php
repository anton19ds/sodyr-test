<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%data_send}}`.
 */
class m230323_200539_create_data_send_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%data_send}}', [
            'id' => $this->primaryKey(),
            'messege_id' => $this->integer(),
            'data' => "longtext CHARACTER SET utf8 NOT NULL",
            'date' => $this->string(),
            'bot_id' => $this->integer(),
            'template_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%data_send}}');
    }
}
