<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lessons */

$this->title = $model->predmet_id . ' ' . date('d.m.Y', strtotime($model->date));
$this->params['breadcrumbs'][] = ['label' => 'Занятия', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lessons-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'student_id',
            'predmet_id',
            'teacher_id',
            'date',
            'visit'=> [
                'attribute'=>'visit',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->visit ? '<i style="font-size: 25px; color: green;" class="glyphicon glyphicon-ok-circle"></i>' : '<i style="font-size: 25px; color: red;" class="glyphicon glyphicon-remove-circle fa-lg"></i>';
                }
            ],
        ],
    ]) ?>

</div>
