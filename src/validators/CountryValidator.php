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
use jlorente\location\db\Country;

/**
 * Validator to check the existence of a country id in the database.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class CountryValidator extends Validator {

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute) {
        parent::validateAttribute($model, $attribute);
        if ($model->$attribute !== null) {
            $country = Country::findOne($model->$attribute);
            if ($country === null) {
                $this->addError($attribute, Yii::t('location', 'Country with id {[id]} doesn\'t exist', [
                            'id' => $model->$attribute
                ]));
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     * 
     * Checks if the given country id exists.
     */
    protected function validateValue($value) {
        if (Country::find()->andWhere(['id' => $value])->exists() === false) {
            return Yii::t('location', 'Country with id {[id]} doesn\'t exist', [
                        'id' => $value
            ]);
        }
    }

}
