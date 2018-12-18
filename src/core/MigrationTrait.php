<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\core;

use jlorente\location\db\City;
use jlorente\location\db\Country;
use jlorente\location\db\Location;
use jlorente\location\db\Region;
use jlorente\location\db\State;
use yii\helpers\Inflector;

/**
 * Trait MigrationTrait
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
trait MigrationTrait
{

    /**
     * Returns the table name of the Country model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getCountryTableName()
    {
        return Country::tableName();
    }

    /**
     * Returns the table name of the State model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getStateTableName()
    {
        return State::tableName();
    }

    /**
     * Returns the table name of the Region model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getRegionTableName()
    {
        return Region::tableName();
    }

    /**
     * Returns the table name of the City model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getCityTableName()
    {
        return City::tableName();
    }

    /**
     * Returns the table name of the Location model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getLocationTableName()
    {
        return Location::tableName();
    }

    /**
     * Returns the foreign key name of the State model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyStateCountry()
    {
        return 'FK_' . Inflector::camelize($this->getStateTableName()) . '_CountryId';
    }

    /**
     * Returns the foreign key name of the Region model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyRegionState()
    {
        return 'FK_' . Inflector::camelize($this->getRegionTableName()) . '_StateId';
    }

    /**
     * Returns the foreign key name of the Region model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyRegionCountry()
    {
        return 'FK_' . Inflector::camelize($this->getRegionTableName()) . '_CountryId';
    }

    /**
     * Returns the foreign key name of the City model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyCityCountry()
    {
        return 'FK_' . Inflector::camelize($this->getCityTableName()) . '_CountryId';
    }

    /**
     * Returns the foreign key name of the City model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyCityState()
    {
        return 'FK_' . Inflector::camelize($this->getCityTableName()) . '_StateId';
    }

    /**
     * Returns the foreign key name of the City model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyCityRegion()
    {
        return 'FK_' . Inflector::camelize($this->getCityTableName()) . '_RegionId';
    }

    /**
     * Returns the foreign key name of the Country model for country_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocCountry()
    {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_CountryId';
    }

    /**
     * Returns the foreign key name of the State model for state_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocState()
    {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_StateId';
    }

    /**
     * Returns the foreign key name of the Location model for region_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocRegion()
    {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_RegionId';
    }

    /**
     * Returns the foreign key name of the Location model for city_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocCity()
    {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_CityId';
    }

}
