<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "fields".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $date
 * @property string|null $before_param
 * @property string|null $after_param
 */
class Fields extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields';
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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['before_param', 'after_param'], 'string'],
            [['name', 'date'], 'string', 'max' => 255],
            [['data'], 'string'],
            [['plaseholder'], 'string'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'date' => 'Дата добавления',
            'before_param' => 'Текст до',
            'after_param' => 'Текст после',
            'data' => 'Группы полей',
            'plaseholder' => 'Содержание'
        ];
    }
}
