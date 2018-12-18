<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\controllers;

use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter,
    yii\filters\AccessControl;
use jlorente\location\Module;
use yii\filters\ContentNegotiator;

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

}
