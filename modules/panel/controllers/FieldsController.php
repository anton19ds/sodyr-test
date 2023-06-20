<?php

namespace app\modules\panel\controllers;

use app\models\Fields;
use app\models\Parse;
use app\models\TelegramBot;
use app\models\Templates;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FieldsController implements the CRUD actions for Fields model.
 */
class FieldsController extends MainController
{
  /**
   * @inheritDoc
   */
  public function behaviors()
  {
    return array_merge(
      parent::behaviors(),
      [
        'verbs' => [
          'class' => VerbFilter::className(),
          'actions' => [
            //'delete' => ['POST'],
          ],
        ],
      ]
    );
  }

  /**
   * Lists all Fields models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Fields::find(),
      /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Fields model.
   * @param int $id ID
   * @return string
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Fields model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Fields();

    if ($this->request->isPost) {
      $data = $this->request->post();
      if ($model->load($data)) {

        if (isset($data['Pole']) && !empty($data['Pole'])) {
          $strJson = json_encode($data['Pole']);
          $model->data = $strJson;
          if ($model->save()) {
            $messege = "<span class=\"badge bg-success\">Переменная добавлена</span>";
            Yii::$app->session->setFlash('flash', $messege);
            return $this->redirect(['view', 'id' => $model->id]);
          }
        }
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Fields model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $reserv = array();
    if(Yii::$app->request->isPost){
      $data = Yii::$app->request->post();
      if($model->load($data)){
        if (isset($data['Pole']) && !empty($data['Pole'])) {
          $strJson = json_encode($data['Pole']);
          $model->data = $strJson;
          if ($model->save()) {
            $messege = "<span class=\"badge bg-success\">Переменная обнавлена</span>";
            Yii::$app->session->setFlash('flash', $messege);
            return $this->redirect(['view', 'id' => $model->id]);
          }
        }
      }
    }
    
    if (!empty($model->data)) {
      $reserv = json_decode($model->data, true);
    }
    return $this->render('update', [
      'model' => $model,
      'reserv' => $reserv
    ]);
  }

  public function actionAddPole()
  {
    if (Yii::$app->request->isAjax) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $data = Yii::$app->request->post();
      $insert = $data['col_param'] + 1;
      return [
        'form' => $this->renderPartial('fields', ['insert' => $insert]),
        'data' => $insert
      ];
    }
  }

  /**
   * Deletes an existing Fields model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    if (Yii::$app->request->post()) {
      $data = Yii::$app->request->post();
    }
    $templates = Templates::find()->asArray()->all();
    $array = array();

    foreach ($templates as $template) {
      if (strripos($template['template'], 'fields id=' . $id)) {
        $array[] = $template['id'];
      }
    }
    if(empty($array)){
      //return $this->redirect('index');
    }
    $dataProvider = new ActiveDataProvider([
      'query' => Templates::find()->where(['id' => $array]),
      'pagination' => [
        'pageSize' => 20,
      ],
    ]);
    
    return $this->render('del', ['array' => $array, 'dataProvider' =>  $dataProvider, 'id' => $id]);
  }

  public function actionDelField($id){
    if (Fields::find()->where(['id' => $id])->exists()) {
      $this->findModel($id)->delete();
      $messege = "<span class=\"badge bg-danger\">Переменная удалена</span>";
      Yii::$app->session->setFlash('flash', $messege);
      return $this->redirect('index');
    }
  }
  public function actionRedTemplate()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      $model = Templates::findOne($data['id']);
      return $this->renderPartial('for-modal', [
        'model' => $model,
        'tg' => TelegramBot::find()->where(['active' => '1'])->all(),
        'field' => Fields::find()->asArray()->all()
      ]);
    }
  }

  public function actionUpdateTemplate()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (!empty($data['Templates']['id'])) {
        $models = Templates::find()->where(['id' => $data['Templates']['id']])->one();
        if (!empty($data['Templates']['template'])) {
          $models->template = json_encode($data['Templates']['template']);
          if ($models->save()) {
            return 'ok';
          } else {
            var_dump($models->getErrors());
          }
        }
      }
    }
  }

  /**
   * Finds the Fields model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Fields the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Fields::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
