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
 * This is the model class for table "jl_loc_location".
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $zone_id
 * @property integer $region_id
 * @property integer $place_id
 * @property string $address
 * @property double $latitude
 * @property double $longitude
 * 
 * @property City $city The city in which this location is located or null if not defined.
 * @property Region $region The region in which this location is located or null if not defined.
 * @property Country $county The country in which this zone is located or null if not defined.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Location extends yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'jl_loc_location';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['country_id', 'region_id', 'city_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('jlorente/location', 'ID'),
            'country_id' => Yii::t('jlorente/location', 'Country ID'),
            'zone_id' => Yii::t('jlorente/location', 'Zone ID'),
            'region_id' => Yii::t('jlorente/location', 'Region ID'),
            'place_id' => Yii::t('jlorente/location', 'Place ID'),
            'address' => Yii::t('jlorente/location', 'Address'),
            'latitude' => Yii::t('jlorente/location', 'Latitude'),
            'longitude' => Yii::t('jlorente/location', 'Longitude'),
        ];
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getRegion() {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

}
