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
 * This is the model class for table "jl_loc_city".
 *
 * @property integer $id
 * @property integer $region_id
 * @property string $name
 * 
 * @property Country $country The country in which this city is located.
 * @property Location[] $locations A collection of Location objects.
 * @property Region $region The region in which this city is located.
 * @property State $state The state in which this city is located.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class City extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jl_loc_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['name', 'required']
            , [['country_id', 'region_id', 'state_id'], 'one_required', 'params' => ['country_id', 'region_id', 'state_id']]
            , [['country_id', 'region_id', 'state_id'], 'integer']
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
            , 'region_id' => Yii::t('jlorente/location', 'Region')
            , 'state_id' => Yii::t('jlorente/location', 'State')
            , 'country_id' => Yii::t('jlorente/location', 'Country')
            , 'name' => Yii::t('jlorente/location', 'Name')
        ]);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::className(), ['city_id' => 'id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

}
