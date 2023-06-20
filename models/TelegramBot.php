<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "telegram_bot".
 *
 * @property int $id
 * @property string|null $bot_id
 * @property string|null $chat_id
 * @property string|null $date
 * @property string|null $name
 */
class TelegramBot extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date'],
                ],
            ],
        ];
    }



    public static function tableName()
    {
        return 'telegram_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'chat_id', 'date', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID в системе',
            'bot_id' => 'Бот ID',
            'chat_id' => 'Чат ID',
            'date' => 'Дата добавления',
            'name' => 'Наименование чата',
        ];
    }
}
