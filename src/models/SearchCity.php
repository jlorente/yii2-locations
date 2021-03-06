<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use jlorente\location\db\City;

/**
 * SearchCity represents the model behind the search form about 
 * `jlorente\location\db\City`.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class SearchCity extends City
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'country_id', 'state_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer']
            , [['name'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = City::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id
            , 'region_id' => $this->region_id
            , 'state_id' => $this->state_id
            , 'country_id' => $this->country_id
            , 'created_at' => $this->created_at
            , 'created_by' => $this->created_by
            , 'updated_at' => $this->updated_at
            , 'updated_by' => $this->updated_by
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }

}
