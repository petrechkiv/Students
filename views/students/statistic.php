<?php

use yii\bootstrap\Collapse;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="students-view">
    <h3>Информация о студенте:</h3>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td>ФИО</td>
            <td><?= $model->fio; ?></td>
        </tr>
        <tr>
            <td>Группа</td>
            <td><?= $model->group_id; ?></td>
        </tr>
        </tbody>
    </table>

    <h3>Предметы которые посещал студент:</h3>
    <?php if (!empty($predmets)): ?>
        <?php foreach ($predmets as $predmet): ?>
            <?= Collapse::widget([
                'items' => [
                    [
                        'label' => $predmet['caption'],
                        'content' => $predmet['info'],
                        'contentOptions' => [],
                        'options' => [],
                    ],
                ]
            ]);
            ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Студент не посетил ниодного занятия!</p>
    <?php endif; ?>

</div>