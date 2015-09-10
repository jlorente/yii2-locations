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
/* @var $model jlorente\location\db\City */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Countries'), 'url' => ['country/index']];
$this->params['breadcrumbs'][] = ['label' => $model->region->country->name, 'url' => ['country/view', 'id' => $model->region->country_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Regions'), 'url' => ['region/index', 'countryId' => $model->region->country_id]];
$this->params['breadcrumbs'][] = ['label' => $model->region->name, 'url' => ['region/view', 'id' => $model->region_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Cities'), 'url' => ['index', 'regionId' => $model->region_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-view">
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