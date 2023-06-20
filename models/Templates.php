<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "templates".
 *
 * @property int $id
 * @property string|null $date
 * @property string|null $name
 * @property string|null $template
 * @property int|null $bot_id
 * @property string|null $param
 */
class Templates extends ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'templates';
  }

  public function behaviors()
  {
    return [
      'timestamp' => [
        'class' => 'yii\behaviors\TimestampBehavior',
        'attributes' => [
          ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
          ActiveRecord::EVENT_BEFORE_UPDATE => ['updata'],
        ],
      ],
    ];
  }


  public function rules()
  {
    return [
      [['bot_id'], 'unique', 'message' => 'Бот уже используется в другом шаблоне'],
      [['bot_id'], 'default', 'value' => null],
      [['name'], 'required'],
      [['template'], 'string'],
      [['bot_id', 'statys'], 'integer'],
      [['updata','date', 'name'], 'string', 'max' => 255],
      [['param'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'date' => 'Дата добавление',
      'updata' => 'Дата  изменения',
      'name' => 'Наименование',
      'template' => 'Шаблон',
      'bot_id' => 'Канал',
      'statys' => 'Активность',
      'param' => 'Параметры',
    ];
  }

  public function getBot()
  {
    return $this->hasOne(TelegramBot::class, ['id' => 'bot_id']);
  }
}
