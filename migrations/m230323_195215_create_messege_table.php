<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messege}}`.
 */
class m230323_195215_create_messege_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $this->createTable('{{%messege}}', [
      'id' => $this->primaryKey(),
      'text' => $this->text(),
      'date' => $this->string(),
      'update_id' => $this->string(),
      'messege_id'  => $this->string(),
      'statys' => "enum('send','nosend') NOT NULL DEFAULT 'nosend'",
    ]);


  }

  /**
   * {@inheritdoc}
   */
  public function safeDown()
  {
    $this->dropTable('{{%messege}}');
  }
}
