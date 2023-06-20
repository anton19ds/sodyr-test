<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%templates}}`.
 */
class m230323_200448_create_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%templates}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'name' => $this->string(),
            'template' => $this->text(),
            'bot_id'=> $this->integer(),
            'param' => $this->text(),
            'statys' =>"enum('0','1') NOT NULL DEFAULT '1'",
            'updata' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%templates}}');
    }
}
