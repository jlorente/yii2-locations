<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\db;

use jlorente\location\db\City;
use jlorente\location\db\Country;
use jlorente\location\db\Region;
use jlorente\location\db\State;
use jlorente\location\validators\CityValidator;
use jlorente\location\validators\CountryValidator;
use jlorente\location\validators\RegionValidator;
use jlorente\location\validators\StateValidator;
use Yii;

/**
 * Trait to use in the model to be localized. 
 * 
 * @property Location $location The location of the user or null if not defined.
 * @property Country $country The country in which this object is located.
 * @property Region $region The region in which this object is located.
 * @property City $city The city in which this object is located.
 * @property State $state The state in which this object is located.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait LocationTrait
{

    /**
     *
     * @var int
     */
    public $city_id;

    /**
     *
     * @var int
     */
    public $country_id;

    /**
     *
     * @var int
     */
    public $region_id;

    /**
     *
     * @var int
     */
    public $state_id;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $postal_code;

    /**
     *
     * @var double
     */
    public $latitude;

    /**
     *
     * @var double
     */
    public $longitude;

    /**
     * @inheritdoc
     */
    public function locationRules()
    {
        return [
            [['country_id', 'region_id', 'city_id', 'state_id'], 'default', 'value' => null]
            , [['country_id', 'region_id', 'city_id', 'state_id'], 'integer']
            , [['address', 'postal_code'], 'string', 'max' => 255]
            , [['address', 'postal_code'], 'trim']
            , [['latitude', 'longitude'], 'double']
            , ['city_id', CityValidator::className(), 'regionAttribute' => 'region_id', 'stateAttribute' => 'state_id', 'countryAttribute' => 'country_id']
            , ['region_id', RegionValidator::className(), 'stateAttribute' => 'state_id', 'countryAttribute' => 'country_id']
            , ['state_id', StateValidator::className(), 'countryAttribute' => 'country_id']
            , ['country_id', CountryValidator::className()]
        ];
    }

    /**
     * Saves the related location object.
     * 
     * @param bool $runValidation
     * @param array $attributeNames
     * @return boolean
     * @see yii\db\ActiveRecord::save()
     */
    public function saveLocation($runValidation = true, $attributeNames = null)
    {
        $location = $this->location;
        if ($location === null) {
            $location = new Location();
        }

        $location->country_id = $this->country_id;
        $location->region_id = $this->region_id;
        $location->city_id = $this->city_id;
        $location->state_id = $this->state_id;
        $location->address = $this->address;
        $location->postal_code = $this->postal_code;
        $location->latitude = $this->latitude;
        $location->longitude = $this->longitude;

        if (is_array($attributeNames)) {
            $attributesNames = array_intersect(
                    ['country_id', 'region_id', 'city_id', 'state_id', 'address', 'postal_code', 'latitude', 'longitude'], $attributesNames
            );
        }
        if (empty($attributeNames)) {
            $attributeNames = null;
        }
        if ($location->save($runValidation, $attributeNames) === false) {
            $this->addErrors($location->getErrors());
            return false;
        }
        $this->location_id = $location->id;
        return true;
    }

    /**
     * Populates the fields in the Trait with the ones get from the stored 
     * Location object.
     */
    public function populateLocationOwner()
    {
        $location = $this->location;
        if ($location !== null) {
            $this->country_id = $location->country_id;
            $this->region_id = $location->region_id;
            $this->city_id = $location->city_id;
            $this->state_id = $location->state_id;
            $this->address = $location->address;
            $this->postal_code = $location->postal_code;
            $this->latitude = $location->latitude;
            $this->longitude = $location->longitude;
        }
    }

    /**
     * @inheritdoc
     */
    public function locationAttributeLabels()
    {
        return [
            'country_id' => Yii::t('jlorente/location', 'Country')
            , 'region_id' => Yii::t('jlorente/location', 'Region')
            , 'city_id' => Yii::t('jlorente/location', 'City')
            , 'state_id' => Yii::t('jlorente/location', 'State')
            , 'address' => Yii::t('jlorente/location', 'Dirección')
            , 'postal_code' => Yii::t('jlorente/location', 'Postal Code')
            , 'latitude' => Yii::t('jlorente/location', 'Latitud')
            , 'longitude' => Yii::t('jlorente/location', 'Longitud')
            , 'country.name' => Yii::t('jlorente/location', 'Country')
            , 'region.name' => Yii::t('jlorente/location', 'Region')
            , 'city.name' => Yii::t('jlorente/location', 'City')
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @inheritdoc
     */
    public function getCountryPropertyName()
    {
        return 'country_id';
    }

    /**
     * @inheritdoc
     */
    public function getRegionPropertyName()
    {
        return 'region_id';
    }

    /**
     * @inheritdoc
     */
    public function getCityPropertyName()
    {
        return 'city_id';
    }

    /**
     * @inheritdoc
     */
    public function getStatePropertyName()
    {
        return 'state_id';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array_merge(parent::fields(), [
            'country_id' => 'country_id'
            , 'region_id' => 'region_id'
            , 'city_id' => 'city_id'
            , 'state_id' => 'state_id'
            , 'address' => 'address'
            , 'postal_code' => 'postal_code'
            , 'latitude' => 'latitude'
            , 'longitude' => 'longitude'
        ]);
    }

}
