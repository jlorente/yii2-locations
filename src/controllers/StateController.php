<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\location\controllers;

use jlorente\location\db\State;
use jlorente\location\models\SearchState;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * StateController implements the CRUD actions for State model.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class StateController extends CrudController
{

    use LocationControllerTrait;

    /**
     * Lists all State models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchState(Yii::$app->request->get());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel
                    , 'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single State model.
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new State model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new State(Yii::$app->request->get());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing State model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing State model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the State model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * 
     * @param integer $id
     * @return State the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = State::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Gets a json list of the countries in the database.
     * 
     * @return array
     */
    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $parent = Yii::$app->request->post('depdrop_parents');
        if (empty($parent[0])) {
            $output = [];
        } else {
            $searchModel = new SearchState($parent);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->setPagination(false);
            $dataProvider->getSort()->defaultOrder = ['name' => SORT_ASC];
            $output = ArrayHelper::toArray($dataProvider->getModels(), ['id', 'name']);
        }
        return [
            'output' => $output
        ];
    }

}
