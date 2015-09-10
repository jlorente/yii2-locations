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
/* @var $searchModel jlorente\location\models\SearchCountry */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('jlorente/location', 'Countries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>
    <p>
        <?=
        Html::a(Yii::t('backend/actions', 'Create {modelClass}', [
                    'modelClass' => Yii::t('jlorente/location', 'Country')
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
    <?php
    $listButton = function ($url, $model) {
        $options = array_merge([
            'title' => Yii::t('jlorente/location', 'Regions'),
            'aria-label' => Yii::t('jlorente/location', 'Regions'),
            'data-pjax' => '0',
        ]);
        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['region/index', 'countryId' => $model->id], $options);
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
