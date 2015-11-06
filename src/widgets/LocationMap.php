<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @copyright	Participae <https://participae.com>
 * @version	1.0
 */

namespace jlorente\location\widgets;

use yii\base\Widget;
use jlorente\location\db\LocationInterface;
use dosamigos\google\maps\Map,
    dosamigos\google\maps\overlays\Marker,
    dosamigos\google\maps\LatLng;
use yii\helpers\Html;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class LocationMap extends Widget {

    /**
     *
     * @var array
     */
    public $mapOptions = [];

    /**
     *
     * @var LocationInterface
     */
    protected $model;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $this->mapOptions = array_merge([
            'width' => '100%',
            'height' => 500,
            'zoom' => 10,
            'minZoom' => 1
                ], $this->mapOptions);
    }

    /**
     * @inheritdoc
     */
    public function run() {
        $coord = new LatLng([
            'lat' => $this->model->latitude,
            'lng' => $this->model->longitude
        ]);
        $this->mapOptions['center'] = $coord;
        $map = new Map($this->mapOptions);
        $marker = new Marker([
            'position' => $coord
        ]);
        $map->addOverlay($marker);
        echo Html::tag('div', $map->display(), ['class' => 'map-canvas']);
    }

    /**
     * 
     * @param LocationInterface $model
     */
    public function setModel(LocationInterface $model) {
        $this->model = $model;
    }

    /**
     * 
     * @return LocationInterface
     */
    public function getModel() {
        return $this->model;
    }

}
