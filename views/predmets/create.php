<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Predmets */

$this->title = 'Добавить Предмет';
$this->params['breadcrumbs'][] = ['label' => 'Предметы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="predmets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
