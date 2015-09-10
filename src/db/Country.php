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
 * This is the model class for table "jl_loc_country".
 *
 * @property integer $id
 * @property string $name
 * 
 * @property Region[] $regions A collection of Region objects.
 * @property Location[] $locations A collection of Location objects.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Country extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'jl_loc_country';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('jlorente/location', 'ID'),
            'name' => Yii::t('jlorente/location', 'Name')
        ]);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getRegion() {
        return $this->hasMany(Region::className(), ['country_id' => 'id']);
    }

    /**
     * 
     * @return yii\db\ActiveQuery
     */
    public function getLocations() {
        return $this->hasMany(Location::className(), ['country_id' => 'id']);
    }

}
