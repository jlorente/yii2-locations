<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\db;

use Yii;
use jlorente\location\exceptions\SaveException;
use jlorente\location\models\Coordinates;
use yii\db\ActiveRecord as BaseActiveRecord;

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
class Location extends BaseActiveRecord {

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
            [['address', 'postal_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('jlorente/location', 'ID'),
            'country_id' => Yii::t('jlorente/location', 'Country'),
            'region_id' => Yii::t('jlorente/location', 'Region'),
            'city_id' => Yii::t('jlorente/location', 'City'),
            'address' => Yii::t('jlorente/location', 'Address'),
            'postal_code' => Yii::t('jlorente/location', 'Postal Code'),
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

    /**
     * 
     * @throws SaveException
     */
    public function updateCoordinates() {
        $address = '';
        if (empty($this->address) === false) {
            $matches = [];
            preg_match('/[^\d]+[\d]*/ui', $this->address, $matches);
            $address = $matches[0];
        }
        $locationString = $this->getLocationString();
        $coordinates = new Coordinates([
            'apiServerKey' => Yii::$app->params['googleApiServerKey']
        ]);
        if ($coordinates->populate($address . ' ' . $locationString, $this->country->code)) {
            $coordinates->populate($locationString, $this->country->code);
        }
        $this->attributes = $coordinates->attributes;
        if ($this->update(true, ['latitude', 'longitude']) === false) {
            throw new SaveException($this);
        }
    }

    /**
     * Gets the string identifying the fixed part of the location.
     * 
     * @return string
     */
    public function getLocationString() {
        $normalized = '';
        if ($this->city !== null) {
            $normalized .= $this->city->name;
        }
        if ($this->region !== null) {
            $normalized .= ' ' . $this->region->name;
        }
        if ($this->postal_code !== null) {
            $normalized .= ' ' . $this->postal_code;
        }
        return $normalized;
    }

}
