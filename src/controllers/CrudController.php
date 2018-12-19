<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\Controller;

/**
 * Base controller class for all the backend module controllers.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class CrudController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                    , [
                        'actions' => ['list']
                        , 'allow' => true
                        , 'roles' => ['@']
                    ]
                    , [
                        'actions' => ['list']
                        , 'allow' => true
                        , 'roles' => ['?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ]
            , 'content' => [
                'class' => ContentNegotiator::className()
                , 'only' => ['list']
                , 'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ]
        ];
    }

    /**
     * Get a filtered array of valid values set by depdrop.
     * 
     * @return array
     */
    protected function getDepDropParents($post = 'depdrop_parents')
    {
        $parents = Yii::$app->request->post($post);
        $filteredParents = [];
        foreach ($parents as $key => $parent) {
            if (is_numeric($parent)) {
                $filteredParents[$key] = $parent;
            }
        }
        return $filteredParents;
    }

}
