<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model jlorente\location\models\SearchCity */
?>
<div class="place-search">
    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'region_id') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'created_at') ?>
    <?= $form->field($model, 'created_by') ?>
    <?= $form->field($model, 'updated_at') ?>
    <?= $form->field($model, 'updated_by') ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('jlorente/location', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('jlorente/location', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>