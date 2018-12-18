<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\models;

use yii\base\Model;
use dosamigos\google\maps\services\GeocodingClient;
use yii\helpers\Json;
use jlorente\location\exceptions\GeocodingApiException;
use yii\base\InvalidConfigException,
    yii\base\InvalidParamException;

/**
 * Class Coordinates to call the geocoding google api.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Coordinates extends Model
{

    /**
     *
     * @var float
     */
    public $latitude;

    /**
     *
     * @var float
     */
    public $longitude;

    /**
     *
     * @var string
     */
    protected $apiServerKey;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->apiServerKey)) {
            throw new InvalidConfigException('A Google api server key must be provided');
        }
    }

    /**
     * Calls the api to search the coordinates for the given $address and 
     * $regionCode.
     * 
     * @param string $address
     * @param string $regionCode
     * @return boolean
     * @throws GeocodingApiException
     */
    public function apiCall($address, $regionCode)
    {
        $result = (new GeocodingClient())->lookup([
            'key' => $this->apiServerKey,
            'address' => $address,
            'region' => $regionCode
                ]
        );
        /*
         * https://console.developers.google.com/project/263658429534/apiui/credential
         * To work, the IP where this method it's executing must be enabled y google developers console
         */
        if ($result['status'] == "REQUEST_DENIED") {
            throw new GeocodingApiException('Configuration Error: This IP is not enabled in Google Developer Console');
        }
        if ($result['status'] !== 'OK' && $result['status'] !== 'ZERO_RESULTS') {
            throw new GeocodingApiException('Request failed');
        }
        if ($result['status'] === 'OK') {
            if (isset($result['results'][0]['geometry']['location']['lng']) === false || isset($result['results'][0]['geometry']['location']['lat']) === false) {
                throw new GeocodingApiException('Unexpected Google Api Response: ' . Json::encode($result));
            }
            $this->longitude = $result['results'][0]['geometry']['location']['lng'];
            $this->latitude = $result['results'][0]['geometry']['location']['lat'];
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets the api server key.
     * 
     * @param string $key
     */
    public function setApiServerKey($key)
    {
        if (is_string($key)) {
            throw new InvalidParamException("Google api key must be a string value");
        }
        $this->apiServerKey = $key;
    }

}
