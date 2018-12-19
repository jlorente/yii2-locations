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
 * $ ./yii migrate --migrationPath=@vendor/jlorente/yii2-locations/src/migrations_20
 * ```
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class m181218_192325_location_module_tables extends Migration
{

    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->getStateTableName(), [
            'id' => Schema::TYPE_PK,
            'country_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
                $this->getForeignKeyStateCountry(), $this->getStateTableName(), 'country_id', $this->getCountryTableName(), 'id', 'CASCADE', 'CASCADE'
        );

        $this->addColumn($this->getRegionTableName(), 'state_id', Schema::TYPE_INTEGER . ' NULL AFTER country_id');
        $this->addForeignKey(
                $this->getForeignKeyRegionState(), $this->getRegionTableName(), 'state_id', $this->getStateTableName(), 'id', 'SET NULL', 'CASCADE'
        );

        $this->addColumn($this->getCityTableName(), 'country_id', Schema::TYPE_INTEGER . ' NULL AFTER id');
        $this->addColumn($this->getCityTableName(), 'state_id', Schema::TYPE_INTEGER . ' NULL AFTER country_id');

        $this->dropForeignKey($this->getForeignKeyCityRegion(), $this->getCityTableName());
        $this->alterColumn($this->getCityTableName(), 'region_id', Schema::TYPE_INTEGER . ' NULL');
        $this->addForeignKey(
                $this->getForeignKeyCityCountry(), $this->getCityTableName(), 'country_id', $this->getCountryTableName(), 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
                $this->getForeignKeyCityState(), $this->getCityTableName(), 'state_id', $this->getStateTableName(), 'id', 'SET NULL', 'CASCADE'
        );
        $this->addForeignKey(
                $this->getForeignKeyCityRegion(), $this->getCityTableName(), 'region_id', $this->getRegionTableName(), 'id', 'SET NULL', 'CASCADE'
        );

        $this->addColumn($this->getLocationTableName(), 'state_id', Schema::TYPE_INTEGER . ' NULL AFTER country_id');
        $this->addForeignKey(
                $this->getForeignKeyLocState(), $this->getLocationTableName(), 'state_id', $this->getStateTableName(), 'id', 'RESTRICT', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey($this->getForeignKeyCityRegion(), $this->getCityTableName());
        $this->dropForeignKey($this->getForeignKeyCityState(), $this->getCityTableName());
        $this->dropForeignKey($this->getForeignKeyCityCountry(), $this->getCityTableName());

        $this->dropForeignKey($this->getForeignKeyRegionState(), $this->getRegionTableName());
        $this->dropForeignKey($this->getForeignKeyRegionCountry(), $this->getRegionTableName());

        $this->dropForeignKey($this->getForeignKeyStateCountry(), $this->getStateTableName());

        $this->dropForeignKey($this->getForeignKeyLocCity(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocRegion(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocState(), $this->getLocationTableName());
        $this->dropForeignKey($this->getForeignKeyLocCountry(), $this->getLocationTableName());

        $this->dropTable($this->getCityTableName());
        $this->dropTable($this->getRegionTableName());
        $this->dropTable($this->getStateTableName());
        $this->dropTable($this->getCountryTableName());
        $this->dropTable($this->getLocationTableName());
    }

}
