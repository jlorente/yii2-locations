<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location;

use Yii;
use yii\base\Module as BaseModule;
use yii\base\BootstrapInterface;

/**
 * Module class for the location module.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Module extends BaseModule implements BootstrapInterface
{

    /**
     *
     * @var array 
     */
    public $messageConfig = [];

    /**
     *
     * @var string 
     */
    public $listRole = '@';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'jlorente\location\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setAliases([
            '@jlorenteLocation' => '@vendor/jlorente/yii2-locations/src',
        ]);
        Yii::$app->i18n->translations['jlorente/location'] = $this->getMessageConfig();
    }

    /**
     * 
     * @return array
     */
    protected function getMessageConfig()
    {
        return array_merge([
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@jlorenteLocation/messages',
            'forceTranslation' => true
                ], $this->messageConfig);
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            //TypeController
            'location/country/list' => 'location/country/list'
            , 'location/region/list' => 'location/region/list'
            , 'location/city/list' => 'location/city/list'
                ], false);
    }

}
