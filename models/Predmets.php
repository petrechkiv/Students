<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "predmets".
 *
 * @property int $id
 * @property string $caption
 * @property int $count_hours
 */
class Predmets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'predmets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count_hours'], 'integer'],
            [['caption'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'caption' => 'Название',
            'count_hours' => 'Количество часов',
        ];
    }
}
