<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */
use jlorente\location\core\MigrationTrait;
use yii\db\Schema;
use yii\db\Migration;

/**
 * Location module tables creation.
 * 
 * To apply this migration run:
 * ```bash
 * $ ./yii migrate --migrationPath=@vendor/jlorente/yii2-locations/src/migrations
 * ```
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class m150910_235325_location_module_tables extends Migration
{

    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
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
                $this->getForeignKeyRegionCountry(), $this->getRegionTableName(), 'country_id', $this->getCountryTableName(), 'id', 'CASCADE', 'CASCADE'
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
                $this->getForeignKeyCityRegion(), $this->getCityTableName(), 'region_id', $this->getRegionTableName(), 'id', 'CASCADE', 'CASCADE'
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
    public function down()
    {
        $this->dropForeignKey($this->getForeignKeyCityRegion(), $this->getCityTableName());
        $this->dropForeignKey($this->getForeignKeyRegionCountry(), $this->getRegionTableName());
        $this->dropForeignKey($this->getForeignKeyLocCity(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocRegion(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocCountry(), $this->getLocationTableName());

        $this->dropTable($this->getCityTableName());
        $this->dropTable($this->getRegionTableName());
        $this->dropTable($this->getCountryTableName());
        $this->dropTable($this->getLocationTableName());
    }

}
