<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lessons */

$this->title = 'Обновить занятие: ' . $predmet . ' ' . date('d.m.Y', strtotime($model->date)) ;
$this->params['breadcrumbs'][] = ['label' => 'Занятия', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $predmet . ' ' . date('d.m.Y', strtotime($model->date)), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="lessons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'teachers' => $teachers,
        'students' => $students,
        'predmets' => $predmets,
    ]) ?>

</div>
