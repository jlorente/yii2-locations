<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\validators;

use Yii;
use yii\validators\Validator;
use jlorente\location\db\City;

/**
 * Validator to check the existence of a city id in the database.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class CityValidator extends Validator
{

    /**
     * If setted, the validator with fill the region attribute with the 
     * country_id of the validated region.
     * 
     * @var string
     */
    public $regionAttribute;

    /**
     * If setted, the validator with fill the country attribute with the 
     * country_id of the validated region.
     * 
     * @var string
     */
    public $stateAttribute;

    /**
     * If setted, the validator with fill the country attribute with the 
     * country_id of the validated region.
     * 
     * @var string
     */
    public $countryAttribute;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);
        if ($model->$attribute !== null) {
            $city = City::findOne($model->$attribute);
            if ($city === null) {
                $this->addError($attribute, Yii::t('location', 'City with id {[id]} doesn\'t exist', [
                            'id' => $model->$attribute
                ]));
                return false;
            }
            if (empty($this->regionAttribute) === false) {
                $model->{$this->regionAttribute} = $city->region_id;
            }
            if (empty($this->stateAttribute) === false) {
                $model->{$this->stateAttribute} = $city->state_id;
            }
            if (empty($this->countryAttribute) === false) {
                $model->{$this->countryAttribute} = $city->country_id;
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     * 
     * Checks if the given city id exists.
     */
    protected function validateValue($value)
    {
        if (City::find()->andWhere(['id' => $value])->exists() === false) {
            return Yii::t('location', 'City with id {[id]} doesn\'t exist', [
                        'id' => $value
            ]);
        }
    }

}
