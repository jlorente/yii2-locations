<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location;

use yii\base\Module as BaseModule;
use Yii;

/**
 * Module class for the location module.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Module extends BaseModule {

    /**
     *
     * @var array 
     */
    public $messageConfig = [];

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'jlorente\location\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->setAliases([
            '@jlorenteLocation' => '@vendor/jlorente/yii2-locations/src',
        ]);
        Yii::$app->i18n->translations['jlorente/location'] = $this->getMessageConfig();
        $this->initDefaults();
    }

    /**
     * 
     * @return array
     */
    protected function getMessageConfig() {
        return array_merge([
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@jlorenteLocation/messages',
            'forceTranslation' => true
                ], $this->messageConfig);
    }

}
