<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model jlorente\location\db\State */

$this->title = Yii::t('jlorente/location', 'Create {modelClass}', [
            'modelClass' => Yii::t('jlorente/location', 'State')
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Countries'), 'url' => ['country/index']];
$this->params['breadcrumbs'][] = ['label' => $model->country->name, 'url' => ['country/view', 'id' => $model->country_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'States'), 'url' => ['index', 'country_id' => $model->country_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
