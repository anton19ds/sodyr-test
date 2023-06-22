<?php

namespace app\modules\panel\controllers;

use app\models\Fields;
use app\models\Messege;
use app\models\TelegramBot;
use app\models\Templates;
use Codeception\Util\Template;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplatesController implements the CRUD actions for Templates model.
 */
class TemplatesController extends MainController
{
  /**
   * @inheritDoc
   */
  public $arrayEm = [
    "😀" => "#128512;",
    "😃" => "#128515;",
    "😄" => "#128516;",
    "😁" => "#128513;",
    "😆" => "#128518;",
    "😅" => "#128517;",
    "🤣" => "#129315;",
    "😂" => "#128514;",
    "🙂" => "#128578;",
    "🙃" => "#128579;",
    "😉" => "#128521;",
    "😊" => "#128522;",
    "😇" => "#128519;",
    "😍" => "#128525;",
    "😗" => "#128535;",
    "😚" => "#128538;",
    "😙" => "#128537;",
    "😋" => "#128523;",
    "😛" => "#128539;",
    "😜" => "#128540;",
    "🤪" => "#129322;",
    "😝" => "#128541;",
    "🤗" => "#129303;",
    "🤭" => "#129325;",
    "🤫" => "#129323;",
    "🤔" => "#129300;",
    "🤐" => "#129296;",
    "🤨" => "#129320;",
    "😐" => "#128528;",
    "😑" => "#128529;",
    "😶" => "#128566;",
    "😏" => "#128527;",
    "😒" => "#128530;",
    "🙄" => "#128580;",
    "😬" => "#128556;",
    "🤥" => "#129317;",
    "😌" => "#128524;",
    "😔" => "#128532;",
    "😪" => "#128554;",
    "🤤" => "#129316;",
    "😴" => "#128564;",
    "😷" => "#128567;",
    "🤕" => "#129301;",
    "🤮" => "#129326;",
    "🤧" => "#129319;",
    "🥵" => "#129397;",
    "🥶" => "#129398;",
    "🤯" => "#129327;",
    "🤠" => "#129312;",
    "🥳" => "#129395;",
    "😎" => "#128526;",
    "🤓" => "#129299;",
    "🧐" => "#129488;",
    "😕" => "#128533;",
    "😟" => "#128543;",
    "😲" => "#128562;",
    "😳" => "#128563;",
    "🥺" => "#129402;",
    "😦" => "#128550;",
    "😢" => "#128546;",
    "😭" => "#128557;",
    "😱" => "#128561;",
    "😖" => "#128534;",
    "😓" => "#128531;",
    "😡" => "#128545;",
    "😠" => "#128544;",
    "🤬" => "#129324;",
    "👿" => "#128127;",
    "💀" => "#128128;",
    "💩" => "#128169;",
    "🤡" => "#129313;",
    "👹" => "#128121;",
    "😹" => "#128569;",
    "🧡" => "#129505;",
    "💯" => "#128175;",
    "💢" => "#128162;",
    "💥" => "#128165;",
    "💫" => "#128171;",
    "💦" => "#128166;",
    "💨" => "#128168;",
    "🕳" => "#128371;",
    "💣" => "#128163;",
    "💬" => "#128172;",
    "🗨" => "#128488;",
    "🗯" => "#128495;",
    "💤" => "#128164;",
    "👋" => "#128075;",
    "🤚" => "#129306;",
    "✋" => "#9995;",
    "🖖" => "#128406;",
    "👌" => "#128076;",
    "👈" => "#128072;",
    "👉" => "#128073;",
    "👆" => "#128070;",
    "👇" => "#128071;",
    "👍" => "#128077;",
    "👎" => "#128078;",
    "👏" => "#128079;",
    "🙌" => "#128588;",
    "🤝" => "#129309;",
    "🙏" => "#128591;",
    "💪" => "#128170;",
    "👀" => "#128064;",
    "👁" => "#128065;",
    "🦈" => "#129416;",
    "🕜" => "#128358;",
    "⛈" => "#9928;",
    "🌤" => "#127780;",
    "🌥" => "#127781;",
    "🌧" => "#127783;",
    "🌩" => "#127785;",
    "🌀" => "#127744;",
    "🔥" => "#128293;",
    "💧" => "#128167;",
    "🎀" => "#127872;",
    "🎁" => "#127873;",
    "🎟" => "#127903;",
    "👓" => "#128083;",
    "🥽" => "#129405;",
    "🥼" => "#129404;",
    "🔇" => "#128263;",
    "🔔" => "#128276;",
    "🎤" => "#127908;",
    "📻" => "#128251;",
    "📱" => "#128241;",
    "📞" => "#128222;",
    "🔋" => "#128267;",
    "💿" => "#128191;",
    "🧮" => "#129518;",
    "🔍" => "#128269;",
    "🔦" => "#128294;",
    "📔" => "#128212;",
    "📖" => "#128214;",
    "📄" => "#128196;",
    "🗞" => "#128478;",
    "📑" => "#128209;",
    "💰" => "#128176;",
    "💵" => "#128181;",
    "🛒" => "#128722;",
    "🔀" => "#128256;",
    "⏫" => "#9195;",
    "🔽" => "#128317;",
    "⏬" => "#9196;",
    "⏺" => "#9210;",
    "🔆" => "#128262;",
    "📶" => "#128246;",
    "✅" => "#9989;",
    "❌" => "#10060;",
    "❎" => "#10062;",
    "❓" => "#10067;",
    "❔" => "#10068;",
    "❕" => "#10069;",
    "❗" => "#10071;",
    "🆗" => "#127383;",
    "🅿" => "#127359;",
    "🆘" => "#127384;",
    "🔻" => "#128315;",
    "🔘" => "#128280;",
  ];

  public function behaviors()
  {
    return array_merge(
      parent::behaviors(),
      [
        'verbs' => [
          'class' => VerbFilter::className(),
          'actions' => [
            'delete' => ['POST'],
          ],
        ],
      ]
    );
  }

  /**
   * Lists all Templates models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Templates::find(),
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
   * Displays a single Templates model.
   * @param int $id ID
   * @return string
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    $messege = Messege::find()->asArray()->all();
    return $this->render('view', [
      'model' => $this->findModel($id),
      'messege' => $messege
    ]);
  }

  /**
   * Creates a new Templates model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Templates();

    if ($this->request->isPost) {

      $data = $this->request->post();
      if ($model->load($data)) {
        $model->template = json_encode($data['Templates']['template']);

        if (!empty($data['Parametr'])) {
          $set = implode(';', $data['Parametr']);
        } else {
          $model->param = '';
        }
        if (!empty($set)) {
          $model->param = $set;
        }
      }

      if ($model->save()) {
        $messege = "<span class=\"badge bg-success\">Шаблон добавлен</span>";
        Yii::$app->session->setFlash('flash', $messege);
        return $this->redirect(['view', 'id' => $model->id]);
      }
    } else {
      $model->loadDefaultValues();
    }


    return $this->render('create', [
      'arrayEm' => $this->arrayEm,
      'model' => $model,
      'tg' => TelegramBot::find()->where(['active' => '1'])->all(),
      'field' => Fields::find()->asArray()->all()
    ]);
  }

  /**
   * Updates an existing Templates model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $arrty = '';
    $model = $this->findModel($id);
    if ($this->request->isPost) {
      $data = $this->request->post();
      if ($model->load($data)) {
        $model->template = json_encode($data['Templates']['template']);
        
        if (!empty($data['Parametr'])) {
          $set = json_encode($data['Parametr']);
        } else {
          $model->param = '';
        }
        if (!empty($set)) {
          $model->param = $set;
        }
      }
      if ($model->save()) {
        $messege = "<span class=\"badge bg-warning\">Шаблон сохранен</span>";
        Yii::$app->session->setFlash('flash', $messege);
        return $this->redirect(['view', 'id' => $model->id]);
      }else{
        var_dump($model->getErrors());
      }
    }
    if (!empty($model->param)) {
      $setr = json_decode($model->param, true);
    } else {
      $setr = false;
    }
    $add = array();
    if($setr){

    
    foreach($setr as $key => $val){
      $add[] = implode(' и ',$val);
    }
    $ert = implode(') или (',$add);
    $arrty = '( '.$ert.' )';
  }
    if(!empty($model->param)){
      $param = json_decode($model->param ,true);
    }else{
      $param = false;
    }
    return $this->render('update', [
      'model' => $model,
      'arrayEm' => $this->arrayEm,
      'tg' => TelegramBot::find()->where(['active' => '1'])->all(),
      'field' => Fields::find()->asArray()->all(),
      'setr' => $arrty,
      'param' => $param
    ]);
  }

  /**
   * Deletes an existing Templates model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    $messege = "<span class=\"badge bg-danger\">Шаблон удален</span>";
    Yii::$app->session->setFlash('flash', $messege);
    return $this->redirect(['index']);
  }

  public function actionAddParam()
  {

    if (Yii::$app->request->isAjax) {

      $data = Yii::$app->request->post();
      $count = (int) $data['count'] + rand(0,999);
      $is = (int) $data['is'];
      

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return [
        'form' => $this->renderPartial('add-param', ['count' => $count, 'is' => $is]),
        'data' => $count
      ];
    }
  }

  public function actionOrParam()
  {
    if(Yii::$app->request->isAjax){
      $data = Yii::$app->request->post();
      $dataSet = $data['count'] + rand(0,999);
      $clod = $data['count'];
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return [
        'form' => $this->renderPartial('or-param', ['data' => $dataSet, 'clod' => $clod]),
        'data' => $data
      ];
      
    }
  }

  public function actionCopy($id)
  {
    if (Templates::find()->where(['id' => $id])->exists()) {
      $template = Templates::find()->where(['id' => $id])->one();
      $model = new Templates([
        'name' => $template->name . " (Копия)",
        'template' => $template->template,
        'bot_id' =>  null,
        'statys' => '0',
        'param' => $template->param
      ]);
      if ($model->save()) {
        return $this->redirect(['update', 'id' => $model->id]);
      } else {
        var_dump($model->getErrors());
      }
    }
  }
  protected function findModel($id)
  {
    if (($model = Templates::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
