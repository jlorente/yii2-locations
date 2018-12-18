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
    yii\helpers\Url,
    yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use yii\base\InvalidConfigException;
use jlorente\location\Module;
use yii\helpers\Inflector;

/**
 * 
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class LocationFormWidget extends Widget
{

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
     * Model name to submit the model. By default will be the model name.
     * 
     * @var LocationInterface
     */
    public $submitModelName;

    /**
     *
     * @var string 
     */
    public $template = "{country}\n{state}\n{region}\n{city}\n{address}\n{postalCode}\n{geolocation}";

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
     *
     * @var array
     */
    protected $fieldIds = [];
    protected $parts = [];

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if ($this->form === null) {
            throw new InvalidConfigException('form property must be provided');
        }

        if ($this->model === null) {
            throw new InvalidConfigException('model property must be provided');
        }

        $this->module = Module::getInstance();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->ensureFieldIds();
        if (isset($this->fieldIds['country'])) {
            $this->country();
        }
        if (isset($this->fieldIds['state'])) {
            $this->state();
        }
        if (isset($this->fieldIds['region'])) {
            $this->region();
        }
        if (isset($this->fieldIds['city'])) {
            $this->city();
        }
        if (isset($this->fieldIds['address'])) {
            $this->address();
        }
        if (isset($this->fieldIds['postal_code'])) {
            $this->postalCode();
        }
        if (isset($this->fieldIds['latitude']) || isset($this->fieldIds['longitude'])) {
            $this->geolocation();
        }
        return strtr($this->template, $this->parts);
    }

    /**
     * Renders the country part.
     */
    protected function country()
    {
        $this->parts['{country}'] = $this->form->field($this->model, $this->model->getCountryPropertyName(), ['options' => ['name' => 'hola']])->dropDownList(
                ArrayHelper::map(Country::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), [
            'id' => $this->fieldIds['country']
            , 'prompt' => Yii::t('jlorente/location', 'Select country')
            , 'name' => $this->getSubmitModelName($this->model->getCountryPropertyName())
        ]);
    }

    /**
     * Renders the region part.
     */
    protected function state()
    {
        $this->parts['{state}'] = $this->form->field($this->model, $this->model->getStatePropertyName())->widget(DepDrop::className(), [
            'options' => [
                'id' => $this->fieldIds['state']
                , 'placeholder' => Yii::t('jlorente/location', 'Select state')
                , 'name' => $this->getSubmitModelName($this->model->getStatePropertyName())
            ]
            , 'data' => ArrayHelper::map(State::find()->where(['country_id' => $this->model->country_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
            , 'pluginOptions' => [
                'url' => Url::to(["/{$this->module->id}/state/list"])
                , 'depends' => [$this->fieldIds['country']]
            ]
        ]);
    }

    /**
     * Renders the region part.
     */
    protected function region()
    {
        $pluginOptions = [
            'url' => Url::to(["/{$this->module->id}/region/list"])
            , 'depends' => [$this->fieldIds['country']]
        ];
        if (isset($this->fieldIds['state'])) {
            $pluginOptions['depends'][] = $this->fieldIds['state'];
            $pluginOptions['initDepends'] = [$this->fieldIds['country']];
        } else {
            $pluginOptions['depends'][] = null;
        }

        $this->parts['{region}'] = $this->form->field($this->model, $this->model->getRegionPropertyName())->widget(DepDrop::className(), [
            'options' => [
                'id' => $this->fieldIds['region']
                , 'placeholder' => Yii::t('jlorente/location', 'Select region')
                , 'name' => $this->getSubmitModelName($this->model->getRegionPropertyName())
            ]
            , 'data' => ArrayHelper::map(Region::find()->where(['country_id' => $this->model->country_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
            , 'pluginOptions' => $pluginOptions
        ]);
    }

    /**
     * Renders the city part.
     */
    protected function city()
    {
        $pluginOptions = [
            'url' => Url::to(["/{$this->module->id}/city/list"])
            , 'depends' => [$this->fieldIds['country']]
        ];
        if (isset($this->fieldIds['state'])) {
            $pluginOptions['depends'][] = $this->fieldIds['state'];
            $pluginOptions['initDepends'] = [$this->fieldIds['country']];
        } else {
            $pluginOptions['depends'][] = null;
        }

        if (isset($this->fieldIds['region'])) {
            $pluginOptions['depends'][] = $this->fieldIds['region'];
            if (isset($this->fieldIds['state'])) {
                $pluginOptions['initDepends'][] = $this->fieldIds['state'];
            }
        } else {
            $pluginOptions['depends'][] = null;
        }

        $this->parts['{city}'] = $this->form->field($this->model, $this->model->getCityPropertyName())->widget(DepDrop::className(), [
            'options' => [
                'id' => $this->fieldIds['city']
                , 'cityholder' => Yii::t('jlorente/location', 'Select city')
                , 'name' => $this->getSubmitModelName($this->model->getCityPropertyName())
            ]
            , 'data' => ArrayHelper::map(City::find()->where(['region_id' => $this->model->region_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
            , 'pluginOptions' => $pluginOptions
        ]);
    }

    /**
     * Renders the address part.
     */
    protected function address()
    {
        $this->parts['{address}'] = $this->form->field($this->model, 'address')->textInput([
            'name' => $this->getSubmitModelName('address')
            , 'id' => $this->fieldIds['address']
        ]);
    }

    /**
     * Renders the postalCode part.
     */
    protected function postalCode()
    {
        $this->parts['{postalCode}'] = $this->form->field($this->model, 'postal_code')->textInput([
            'name' => $this->getSubmitModelName('postal_code')
            , 'id' => $this->fieldIds['postal_code']
        ]);
    }

    /**
     * Renders the geolocation part.
     */
    protected function geolocation()
    {
        $this->parts['{geolocation}'] = $this->form->field($this->model, 'latitude')->textInput([
                    'name' => $this->getSubmitModelName('latitude')
                    , 'id' => $this->fieldIds['latitude']
                ])
                . "\n"
                . $this->form->field($this->model, 'longitude')->textInput([
                    'name' => $this->getSubmitModelName('longitude')
                    , 'id' => $this->fieldIds['longitude']
        ]);
    }

    /**
     * 
     * @param ActiveForm $activeForm
     */
    public function setForm(ActiveForm $activeForm)
    {
        $this->form = $activeForm;
    }

    /**
     * 
     * @param LocationInterface $model
     */
    public function setModel(LocationInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Gets the submit model name.
     * 
     * @param string $attribute
     * @return string
     */
    public function getSubmitModelName($attribute)
    {
        return empty($this->submitModelName) ? Html::getInputName($this->model, $attribute) : $this->submitModelName . "[$attribute]";
    }

    /**
     * Ensures the field ids names.
     */
    protected function ensureFieldIds()
    {
        if ($this->submitModelName) {
            $formName = Inflector::slug($this->submitModelName, '_');
        } else {
            $model = new \ReflectionClass($this->model);
            $formName = $model->getShortName();
        }
        $parts = [];
        preg_match_all('/{([^}]+)}/', $this->template, $parts);
        $keys = array_flip($parts[1]);
        $fieldIds = [];
        if (isset($keys['country'])) {
            $fieldIds['country'] = $formName . '_country_id';
        }
        if (isset($keys['state'])) {
            $fieldIds['state'] = $formName . '_state_id';
        }
        if (isset($keys['region'])) {
            $fieldIds['region'] = $formName . '_region_id';
        }
        if (isset($keys['city'])) {
            $fieldIds['city'] = $formName . '_city_id';
        }
        if (isset($keys['address'])) {
            $fieldIds['address'] = $formName . '_address';
        }
        if (isset($keys['postalCode'])) {
            $fieldIds['postal_code'] = $formName . '_postal_code';
        }
        if (isset($keys['geolocation'])) {
            $fieldIds['latitude'] = $formName . '_latitude';
            $fieldIds['longitude'] = $formName . '_longitude';
        }
        $this->fieldIds = $fieldIds;
    }

}
