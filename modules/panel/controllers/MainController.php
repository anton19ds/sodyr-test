<?php

namespace app\modules\panel\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Messege;
use yii\httpclient\Client;

class MainController extends Controller
{
  public function beforeAction($action)
  {
    if(Yii::$app->user->isGuest){
      return $this->redirect('/login');
    }
    return parent::beforeAction($action);
  }
}
