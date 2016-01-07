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
use jlorente\location\Module;
use yii\widgets\ActiveField;

/**
 * 
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class LocationFormWidget extends Widget {

    /**
     *
     * @var array
     */
    protected $parts;

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
    public $template = "{country}\n{region}\n{city}\n{address}\n{postalCode}\n{geolocation}";

    /**
     *
     * @var string
     */
    public $localized = 'address';

    /**
     *
     * @var Module
     */
    protected $module;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init() {
        parent::init();

        if ($this->form === null) {
            throw InvalidConfigException('form property must be provided');
        }

        if ($this->model === null) {
            throw InvalidConfigException('model property must be provided');
        }
        $this->module = Module::getInstance();
    }

    /**
     * @inheritdoc
     */
    public function run() {
        $this->country();
        $this->region();
        $this->city();
        $this->address();
        $this->postalCode();
        $this->geolocation();
        return strtr($this->template, $this->parts);
    }

    /**
     * Renders the country part.
     */
    protected function country() {
        $this->parts['{country}'] = $this->form->field($this->model, $this->model->getCountryPropertyName())->dropDownList(
                ArrayHelper::map(
                        Country::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), [
            'id' => 'location_country_id',
            'prompt' => Yii::t('jlorente/location', 'Select country'),
        ]);
    }

    /**
     * Renders the region part.
     */
    protected function region() {
        $this->parts['{region}'] = $this->form->field($this->model, $this->model->getRegionPropertyName())->widget(DepDrop::className(), [
            'options' => ['id' => 'location_region_id', 'placeholder' => Yii::t('jlorente/location', 'Select region')],
            'data' => ArrayHelper::map(Region::find()->where(['country_id' => $this->model->country_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
            'pluginOptions' => [
                'url' => Url::to(["/{$this->module->id}/region/list"]),
                'depends' => ['location_country_id']
            ]
        ]);
    }

    /**
     * Renders the city part.
     */
    protected function city() {
        $this->parts['{city}'] = $this->form->field($this->model, $this->model->getCityPropertyName())->widget(DepDrop::className(), [
            'options' => ['id' => 'location_city_id', 'cityholder' => Yii::t('jlorente/location', 'Select city')],
            'data' => ArrayHelper::map(City::find()->where(['region_id' => $this->model->region_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
            'pluginOptions' => [
                'url' => Url::to(["/{$this->module->id}/city/list"]),
                'depends' => ['location_region_id']
            ]
        ]);
    }

    /**
     * Renders the address part.
     */
    protected function address() {
        $this->parts['{address}'] = $this->form->field($this->model, 'address')->textInput();
    }

    /**
     * Renders the postalCode part.
     */
    protected function postalCode() {
        $this->parts['{postalCode}'] = $this->form->field($this->model, 'postal_code')->textInput();
    }

    /**
     * Renders the geolocation part.
     */
    protected function geolocation() {
        $this->parts['{geolocation}'] = $this->form->field($this->model, 'latitude') . "\n" . $this->form->field($this->model, 'longitude');
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
