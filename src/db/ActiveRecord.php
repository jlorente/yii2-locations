<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\db;

use yii\db\ActiveRecord as BaseActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior,
    yii\behaviors\BlameableBehavior;

/**
 * 
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
abstract class ActiveRecord extends BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ]);
    }

    /**
     * 
     * @param string $attribute
     * @param array $params
     * @param Validator $validator
     * @return boolean
     */
    public function one_required($attribute, $params, $validator)
    {
        $required = current((array) $params);
        $value = $this->$attribute;
        if ($value) {
            return true;
        }
        foreach ($required as $rAttribute) {
            if ($this->$rAttribute) {
                return true;
            }
        }
        $this->addError($attribute, 'One of the attributes [' . implode(',', $required) . '] must not be null.');
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'created_at' => Yii::t('jlorente/location', 'Created At'),
            'created_by' => Yii::t('jlorente/location', 'Created By'),
            'updated_at' => Yii::t('jlorente/location', 'Updated At'),
            'updated_by' => Yii::t('jlorente/location', 'Updated By'),
        ];
    }

}
