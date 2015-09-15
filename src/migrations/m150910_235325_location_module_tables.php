<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use yii\db\Schema;
use yii\db\Migration;
use jlorente\location\db\Country,
    jlorente\location\db\Region,
    jlorente\location\db\City,
    jlorente\location\db\Location;
use yii\helpers\Inflector;

/**
 * Location module tables creation.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class m150910_235325_location_module_tables extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable($this->getCountryTableName(), [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'code' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER
        ]);
        $this->createTable($this->getRegionTableName(), [
            'id' => Schema::TYPE_PK,
            'country_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
                $this->getForeignKeyRegion(), $this->getRegionTableName(), 'country_id', $this->getCountryTableName(), 'id', 'CASCADE', 'CASCADE'
        );
        $this->createTable($this->getCityTableName(), [
            'id' => Schema::TYPE_PK,
            'region_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
                $this->getForeignKeyCity(), $this->getCityTableName(), 'region_id', $this->getRegionTableName(), 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable($this->getLocationTableName(), [
            'id' => Schema::TYPE_PK,
            'country_id' => Schema::TYPE_INTEGER,
            'region_id' => Schema::TYPE_INTEGER,
            'city_id' => Schema::TYPE_INTEGER,
            'address' => Schema::TYPE_STRING,
            'postal_code' => Schema::TYPE_STRING,
            'latitude' => Schema::TYPE_DOUBLE,
            'longitude' => Schema::TYPE_DOUBLE
        ]);
        $this->addForeignKey(
                $this->getForeignKeyLocCountry(), $this->getLocationTableName(), 'country_id', $this->getCountryTableName(), 'id', 'RESTRICT', 'CASCADE'
        );
        $this->addForeignKey(
                $this->getForeignKeyLocRegion(), $this->getLocationTableName(), 'region_id', $this->getRegionTableName(), 'id', 'RESTRICT', 'CASCADE'
        );
        $this->addForeignKey(
                $this->getForeignKeyLocCity(), $this->getLocationTableName(), 'city_id', $this->getCityTableName(), 'id', 'RESTRICT', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropForeignKey($this->getForeignKeyCity(), $this->getCityTableName());
        $this->dropForeignKey($this->getForeignKeyRegion(), $this->getRegionTableName());
        $this->dropForeignKey($this->getForeignKeyLocCity(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocRegion(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocCountry(), $this->getLocationTableName());

        $this->dropTable($this->getCityTableName());
        $this->dropTable($this->getRegionTableName());
        $this->dropTable($this->getCountryTableName());
        $this->dropTable($this->getLocationTableName());
    }

    /**
     * Returns the table name of the Country model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getCountryTableName() {
        return Country::tableName();
    }

    /**
     * Returns the table name of the Region model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getRegionTableName() {
        return Region::tableName();
    }

    /**
     * Returns the table name of the City model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getCityTableName() {
        return City::tableName();
    }

    /**
     * Returns the table name of the Location model. You can override this 
     * method in order to provide a custom table name.
     * 
     * @return string
     */
    protected function getLocationTableName() {
        return Location::tableName();
    }

    /**
     * Returns the foreign key name of the Region model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyRegion() {
        return 'FK_' . Inflector::camelize($this->getRegionTableName()) . '_CountryId';
    }

    /**
     * Returns the foreign key name of the City model. You can override this 
     * method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyCity() {
        return 'FK_' . Inflector::camelize($this->getCityTableName()) . '_RegionId';
    }

    /**
     * Returns the foreign key name of the Country model for country_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocCountry() {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_CountryId';
    }

    /**
     * Returns the foreign key name of the Location model for region_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocRegion() {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_RegionId';
    }

    /**
     * Returns the foreign key name of the Location model for city_id. You can 
     * override this method in order to provide a custom foreign key name.
     * 
     * @return string
     */
    protected function getForeignKeyLocCity() {
        return 'FK_' . Inflector::camelize($this->getLocationTableName()) . '_CityId';
    }

}
