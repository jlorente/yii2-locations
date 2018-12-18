<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\db;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
interface LocationInterface
{

    /**
     * @return array
     */
    public function locationRules();

    /**
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getLocation();

    /**
     * @return string
     */
    public function getCountryPropertyName();

    /**
     * @return string
     */
    public function getCityPropertyName();

    /**
     * @return string
     */
    public function getRegionPropertyName();

    /**
     * @return string
     */
    public function getStatePropertyName();
}
