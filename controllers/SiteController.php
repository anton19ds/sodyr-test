<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Messege;
use yii\httpclient\Client;

class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'only' => ['logout'],
        'rules' => [
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {


    $client = new Client();
    $response = $client->createRequest()
      ->setMethod('GET')
      ->setUrl('https://api.telegram.org/'.$_ENV['TELEGRAM_MAIN'].'/getUpdates')
      ->send();
    if ($response->isOk) {
      echo "<pre>";
      $array = $response->data; 
      print_r($array);
      if(!empty($array) && !empty($array['result'])){
        foreach($array['result'] as $item){
          if(!Messege::find()->where(['update_id' => $item['update_id']])->andWhere(['messege_id' => $item['message']['message_id']])->exists()){
            $model = new Messege([
              'update_id' => $item['update_id'],
              'messege_id' => $item['message']['message_id'],
              'text' => $item['message']['text'],
              'statys' => 'nosend'
            ]);
            $model->save();
          }
        }

      }
    }
    // return $this->render('index');
  }

  /**
   * Login action.
   *
   * @return Response|string
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->redirect('/panel/messege');
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->redirect('/panel/messege');
    }

    $model->password = '';
    return $this->render('login', [
      'model' => $model,
    ]);
  }

  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();

    return $this->goHome();
  }

  /**
   * Displays contact page.
   *
   * @return Response|string
   */
  public function actionContact()
  {
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      Yii::$app->session->setFlash('contactFormSubmitted');

      return $this->refresh();
    }
    return $this->render('contact', [
      'model' => $model,
    ]);
  }

  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout()
  {
    return $this->render('about');
  }
}
