<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lessons".
 *
 * @property int $id
 * @property int $student_id
 * @property int $predmet_id
 * @property int $teacher_id
 * @property int $visit
 * @property string $date
 */
class Lessons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lessons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'predmet_id', 'teacher_id', 'visit'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Студент',
            'predmet_id' => 'Предмет',
            'teacher_id' => 'Учитель',
            'visit' => 'Был ли студент на занятии',
            'date' => 'Дата',
        ];
    }
}
