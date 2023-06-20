<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "data_send".
 *
 * @property int $id
 * @property string $messege_id
 * @property string $data
 * @property string $date
 * @property int|null $bot_id
 * @property int $template_id
 */
class DataSend extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_send';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['messege_id', 'data', 'template_id'], 'required'],
            [['data'], 'string'],
            [['bot_id', 'template_id'], 'integer'],
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
            'messege_id' => 'Messege ID',
            'data' => 'Data',
            'date' => 'Date',
            'bot_id' => 'Bot ID',
            'template_id' => 'Template ID',
        ];
    }
}
