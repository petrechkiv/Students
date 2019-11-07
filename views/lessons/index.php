<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LessonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Занятия';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (Yii::$app->user->identity->role === 'teacher') {
        echo '<p>'.Html::a('Добавить Занятие', ['create'], ['class' => 'btn btn-success']).'</p>';
    }

    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute'=>'student_id',
            'format' => 'raw',
            'value' => function($model) use ($students) {
                return Html::a(Html::encode($students[$model->student_id]), Url::to(['/students/statistic', 'id' => $model->student_id]));
            }
        ],
        [
            'attribute'=>'predmet_id',
            'format' => 'raw',
            'value' => function($model) use ($predmets) {
                return $predmets[$model->predmet_id];
            }
        ],
        [
            'attribute'=>'teacher_id',
            'format' => 'raw',
            'value' => function($model) use ($teachers) {
                return $teachers[$model->teacher_id];
            }
        ],
        'date',
        [
            'attribute'=>'visit',
            'label'=>'Визит',
            'format' => 'raw',
            'value' => function($model){
                return $model->visit ? '<i style="font-size: 20px; color: green;" class="glyphicon glyphicon-ok-circle"></i>' : '<i style="font-size: 20px; color: red;" class="glyphicon glyphicon-remove-circle fa-lg"></i>';

            }
        ],
    ];

    if (Yii::$app->user->identity->role === 'teacher') {
        $columns[] = ['class' => 'yii\grid\ActionColumn'];
    }

    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>


</div>
