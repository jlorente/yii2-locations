<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\validators;

use jlorente\location\db\State;
use Yii;
use yii\validators\Validator;

/**
 * Validator to check the existence of a state id in the database.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class StateValidator extends Validator
{

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
            $state = State::findOne($model->$attribute);
            if ($state === null) {
                $this->addError($attribute, Yii::t('location', 'State with id {[id]} doesn\'t exist', [
                            'id' => $model->$attribute
                ]));
                return false;
            }
            if (empty($this->countryAttribute) === false) {
                $model->{$this->countryAttribute} = $state->country_id;
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     * 
     * Checks if the given region id exists.
     */
    protected function validateValue($value)
    {
        if (State::find()->andWhere(['id' => $value])->exists() === false) {
            return Yii::t('location', 'State with id {[id]} doesn\'t exist', [
                        'id' => $value
            ]);
        }
    }

}
