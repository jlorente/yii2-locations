<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\db;

use Yii;

/**
 * This is the model class for table "jl_loc_region".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $name
 * 
 * @property City[] $cities A collection of City objects.
 * @property Country $country The country in which this region is located.
 * @property Location[] $locations A collection of Location objects.
 * @property State $state The state in which this region is located.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Region extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jl_loc_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['name', 'required']
            , [['country_id', 'state_id'], 'one_required', ['country_id', 'state_id']]
            , [['country_id', 'state_id'], 'integer']
            , [['name'], 'string', 'max' => 255]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('jlorente/location', 'ID')
            , 'country_id' => Yii::t('jlorente/location', 'Country')
            , 'state_id' => Yii::t('jlorente/location', 'State')
            , 'cities' => Yii::t('jlorente/location', 'Cities')
            , 'name' => Yii::t('jlorente/location', 'Name')
        ]);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['region_id' => 'id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::className(), ['region_id' => 'id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

}
