<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel jlorente\location\models\SearchRegion */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('jlorente/location', 'Regions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('jlorente/location', 'Countries'), 'url' => ['country/index']];
$this->params['breadcrumbs'][] = ['label' => $searchModel->country->name, 'url' => ['country/view', 'id' => $searchModel->country_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?=
        Html::a(Yii::t('jlorente/location', 'Create {modelClass}', [
                    'modelClass' => 'Region'
                ]), ['create', 'countryId' => $searchModel->country_id], [
            'class' => 'btn btn-success'
        ])
        ?>
    </p>
    <?php
    $listButton = function ($url, $model) {
        $options = array_merge([
            'title' => Yii::t('jlorente/location', 'Cities'),
            'aria-label' => Yii::t('jlorente/location', 'Cities'),
            'data-pjax' => '0',
        ]);
        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['city/index', 'regionId' => $model->id], $options);
    };
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {list}',
                'buttons' => [
                    'list' => $listButton
                ]
            ],
        ],
    ]);
    ?>
</div>