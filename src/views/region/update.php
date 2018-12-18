<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model jlorente\location\db\Region */

$this->title = Yii::t('jlorente/location', 'Update {modelClass}: ', [
            'modelClass' => Yii::t('jlorente/location', 'Region'),
        ]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Countries'), 'url' => ['country/index']];
$this->params['breadcrumbs'][] = ['label' => $model->state->country->name, 'url' => ['country/view', 'id' => $model->state->country_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'States'), 'url' => ['state/index', 'country_id' => $model->state->country_id]];
$this->params['breadcrumbs'][] = ['label' => $model->state->name, 'url' => ['state/view', 'id' => $model->state_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Regions'), 'url' => ['index', 'country_id' => $model->state->country_id, 'state_id' => $model->state_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('jlorente/location', 'Update');
?>
<div class="region-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>