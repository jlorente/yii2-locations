<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\db;

/**
 * Trait to use in the model to be localized. 
 * 
 * @property Location $location The location of the user or null if not defined.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait LocationTrait {

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
    public $city_id;

    /**
     *
     * @var string
     */
    public $address;

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
    public function locationRules() {
        return [
            [['country_id', 'region_id', 'city_id'], 'integer'],
            ['address', 'string'],
            [['latitude', 'longitude'], 'double'],
            ['city_id', 'validateCity'],
            ['region_id', 'validateRegion'],
            ['country_id', 'validateCountry'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateCity() {
        if ($this->city_id !== null) {
            $city = City::findOne($this->city_id);
            if ($city === null) {
                $this->addError('city_id', Yii::t('location', 'City with id {[id]} doesn\'t exist', [
                            'id' => $this->city_id
                ]));
                return false;
            }
            $this->region_id = $city->region_id;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validateRegion() {
        if ($this->region_id !== null) {
            $region = Region::findOne($this->region_id);
            if ($region === null) {
                $this->addError('zone_id', Yii::t('location', 'Region with id {[id]} doesn\'t exist', [
                            'id' => $this->region_id
                ]));
                return false;
            }
            $this->country_id = $region->country_id;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validateCountry() {
        if ($this->country_id !== null) {
            $country = Country::findOne($this->country_id);
            if ($country === null) {
                $this->addError('country_id', Yii::t('location', 'Country with id {[id]} doesn\'t exist', [
                            'id' => $this->country_id
                ]));
                return false;
            }
        }
        return true;
    }

    /**
     * Saves the related location object.
     * 
     * @param bool $runValidation
     * @param array $attributeNames
     * @return boolean
     * @see yii\db\ActiveRecord::save()
     */
    public function saveLocation($runValidation = true, $attributeNames = null) {
        $location = $this->location;
        if ($location === null) {
            $location = new Location();
        }

        $location->country_id = $this->country_id;
        $location->region_id = $this->region_id;
        $location->city_id = $this->city_id;
        $location->address = $this->address;
        $location->latitude = $this->latitude;
        $location->longitude = $this->longitude;

        if (is_array($attributeNames)) {
            $attributesNames = array_intersect(
                    ['country_id', 'region_id', 'city_id', 'address', 'latitude', 'longitude'], $attributesNames
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
    public function populateLocationOwner() {
        $location = $this->location;
        if ($location !== null) {
            $this->country_id = $location->country_id;
            $this->region_id = $location->region_id;
            $this->city_id = $location->city_id;
            $this->address = $location->address;
            $this->latitude = $location->latitude;
            $this->longitude = $location->longitude;
        }
    }

    /**
     * @inheritdoc
     */
    public function getLocation() {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    /**
     * @inheritdoc
     */
    public function getCountryPropertyName() {
        return 'country_id';
    }

    /**
     * @inheritdoc
     */
    public function getRegionPropertyName() {
        return 'region_id';
    }

    /**
     * @inheritdoc
     */
    public function getCityPropertyName() {
        return 'city_id';
    }

}
