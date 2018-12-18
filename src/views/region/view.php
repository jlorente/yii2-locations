<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model jlorente\location\db\Region */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Countries'), 'url' => ['country/index']];
$this->params['breadcrumbs'][] = ['label' => $model->state->country->name, 'url' => ['country/view', 'id' => $model->state->country_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'States'), 'url' => ['state/index', 'country_id' => $model->state->country_id]];
$this->params['breadcrumbs'][] = ['label' => $model->state->name, 'url' => ['state/view', 'id' => $model->state_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Regions'), 'url' => ['index', 'country_id' => $model->state->country_id, 'state_id' => $model->state_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('jlorente/location', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('jlorente/location', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('jlorente/location', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
        <?=
        Html::a(Yii::t('jlorente/location', 'Cities'), ['city/index', 'region_id' => $model->id], [
            'class' => 'btn btn-info pull-right',
        ])
        ?>
    </p>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ])
    ?> 
</div>