<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messege".
 *
 * @property int $id
 * @property string|null $text
 * @property string|null $date
 */
class Messege extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const STATUS_SEND = 'send';
    const STATUS_NOSEND = 'nosend';

    public static function tableName()
    {
        return 'messege';
    }

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

    public function rules()
    {
        return [
            [['text'], 'string'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'date' => 'Дата',
        ];
    }
}
