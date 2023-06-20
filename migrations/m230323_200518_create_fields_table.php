<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fields}}`.
 */
class m230323_200518_create_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fields}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'date' => $this->string(),
            'before_param' => $this->text(),
            'after_param' => $this->text(),
            'data' => $this->text(),
            'plaseholder' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fields}}');
    }
}
