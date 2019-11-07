<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Predmets */

$this->title = 'Обновить предмет: ' . $model->caption;
$this->params['breadcrumbs'][] = ['label' => 'Предмет', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->caption, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="predmets-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
