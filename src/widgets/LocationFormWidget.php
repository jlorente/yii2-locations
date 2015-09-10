<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\widgets;

use Yii;
use yii\base\Widget;
use jlorente\location\db\LocationInterface,
    jlorente\location\db\Country,
    jlorente\location\db\Region,
    jlorente\location\db\City;
use yii\helpers\ArrayHelper,
    yii\helpers\Url;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use yii\base\InvalidConfigException;

/**
 * 
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class LocationFormWidget extends Widget {

    /**
     *
     * @var ActiveForm
     */
    protected $form;

    /**
     *
     * @var LocationInterface
     */
    protected $model;

    /**
     *
     * @var string
     */
    public $localized = 'address';

    public function init() {
        parent::init();

        if ($this->form === null) {
            throw InvalidConfigException('form property must be provided');
        }

        if ($this->model === null) {
            throw InvalidConfigException('model property must be provided');
        }
    }

    public function run() {
        echo $this->form->field($this->model, $this->model->getCountryPropertyName())->dropDownList(
                ArrayHelper::map(
                        Country::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), [
            'id' => 'location_country_id',
            'prompt' => Yii::t('common/geo/country', 'Select country'),
        ]);
        if ($this->localized === $this->model->getCountryPropertyName()) {
            return;
        }
        echo $this->form->field($this->model, $this->model->getRegionPropertyName())->widget(DepDrop::className(), [
            'options' => ['id' => 'location_region_id', 'placeholder' => Yii::t('common/geo/region', 'Select region')],
            'data' => ArrayHelper::map(Region::find()->where(['country_id' => $this->model->country_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
            'pluginOptions' => [
                'url' => Url::to(['/geo/region/list']),
                'depends' => ['location_country_id']
            ]
        ]);
        if ($this->localized === $this->model->getRegionPropertyName()) {
            return;
        }
        echo $this->form->field($this->model, $this->model->getCityPropertyName())->widget(DepDrop::className(), [
            'options' => ['id' => 'location_city_id', 'cityholder' => Yii::t('common/geo/city', 'Select city')],
            'data' => ArrayHelper::map(City::find()->where(['region_id' => $this->model->region_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
            'pluginOptions' => [
                'url' => Url::to(['/geo/city/list']),
                'depends' => ['location_region_id']
            ]
        ]);
        if ($this->localized === $this->model->getCityPropertyName()) {
            return;
        }
        echo $this->form->field($this->model, 'address')->textInput();
    }

    /**
     * 
     * @param ActiveForm $activeForm
     */
    public function setForm(ActiveForm $activeForm) {
        $this->form = $activeForm;
    }

    /**
     * 
     * @param LocationInterface $model
     */
    public function setModel(LocationInterface $model) {
        $this->model = $model;
    }

}
