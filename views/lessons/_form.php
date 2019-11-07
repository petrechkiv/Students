<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Lessons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lessons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->widget(Select2::classname(), [
        'data' => $students,
        'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Выбрать студента...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'predmet_id')->widget(Select2::classname(), [
        'data' => $predmets,
        'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Выбрать предмет...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'teacher_id')->widget(Select2::classname(), [
        'data' => $teachers,
        'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Выбрать учителя...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?=  $form->field($model, 'date')->widget(DatePicker::className(),[
        'name' => 'dp_1',
        'type' => DatePicker::TYPE_BUTTON,
        'options' => ['placeholder' => 'Ввод даты...'],
        'convertFormat' => true,
        'value'=>  $model->date,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd',
            'autoclose'=>true,
            'weekStart'=>1, //неделя начинается с понедельника
            'endDate' => '+0d', //самая ранняя возможная дата
            'todayHighlight' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'visit')->checkbox(); ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
