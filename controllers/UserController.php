<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\Userbank;
use Yii;
use app\models\User;
use app\search\UserSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
	    $behaviors = parent::behaviors();
	    $behaviors['verbs'] = [
		    'class' => VerbFilter::class,
		    'actions' => [
			    'delete' => ['post'],
			    'bulk-delete' => ['post'],
		    ],
	    ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['delete','bulk-delete'],
            'rules' => [
                [
                    'actions' => ['delete','bulk-delete'],
                    'allow' => true,
                    'roles' => ['deleteUser'],
                ]
            ],
        ];
	    return $behaviors;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$dataProvider->sort = [
			'defaultOrder' => [
				'status' => SORT_DESC,
				'id' => SORT_ASC,
			]
		];

        if ($searchModel->status === '') {
            $searchModel->status = null;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Пользователь #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Редактировать',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionAddRecvisitos()
    {
        $request = Yii::$app->request;
        $model = $this->findModel(Yii::$app->user->id);
		$model->scenario  = $model::SCENARIO_UPDATE_BANK_DETAILS;

        if ($model->load($request->post()) && $model->save()) {
            return $this->goHome();
        }

        return $this->render('addRec', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new User();
        $roles = $this->getRoles();

        $params = [
            'model' => $model,
            'roles' => $roles,
        ];

        $model->auth_key = ($model->auth_key)?$model->auth_key:'';
        $model->email = ($model->email)?$model->email:'';

        if( $model->load($request->post())
            && $model->save()
        ){
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Новый пользователь",
                    'content'=>'<span class="text-success">Новый пользователь создан успешно!</span>',
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Добавить ещё',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error',Html::errorSummary($model));
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Новый пользователь",
                'content'=>$this->renderAjax('create', $params),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        } else {
            return $this->render('update', $params);
        }
    }

    /**
     * Updates an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param bool $bankForm Этот параметр передается на странице site/index, чтобы вывести модальное окно другого типа
     * @return mixed
     */
    public function actionUpdate($id = 0, $bankForm = false)
    {
        // Если id == 0, значит пользователь зашел в кабинет для редактирования банковских данных
        if($id == 0) {
            // Присваиваем id из сессии
            $id = Yii::$app->user->id;
            $bankForm = true;
        }
        // У нас есть две страницы с данными - все данные для админов и банковские данные для всех.
        // Определяем какую страницу выводить пользователю
        if($bankForm == false) {
            $model = $this->findModel($id);
            $page = 'update';
        } else {
            $model = $this->findModelBank($id);
            $page = 'updateBank';
        }
        // Надо предотвратить случаи, когда обычные пользователи могли бы вызывать страницу редактирования данных
        // других пользователей. Для этого сравниваем роли
        $userRole = AuthAssignment::find()->where(['user_id' => Yii::$app->user->id])->one();
        // Кому разрешаем редактировать чужие данные
        $granted = [
            'Администратор',
            'Руководитель отдела отзывов',
            'Руководитель продаж'
        ];
        // Сраниваем роль пользователя с ролями, кому можно редактировать данные
        if(!in_array($userRole->item_name, $granted)) {
            // Если человек не админ и пытается редактировать чужие данные, выдаем ошибку
            if($id != Yii::$app->user->id) {
                throw new NotFoundHttpException(self::errorCode()[404]);
            }
        }

        $request = Yii::$app->request;

		$model->scenario  = $model::SCENARIO_UPDATE_POST;

        $roles = $this->getRoles();

        $params = [
            'model' => $model,
            'roles' => $roles,
        ];

        if($model->load($request->post()) && $model->save()) {
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($bankForm == false) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Пользователь #" . $id,
                        'content' => '<span class="text-success">Пользователь успешно изменён!</span>',
                        'footer' => Html::button('Закрыть',
                            ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                            Html::a('Редактировать', [$page, 'id' => $id],
                            ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                } else {
                    Yii::$app->session->setFlash('success', "Данные вашего аккаунта успешно обновлены.");
                    $this->redirect(['./']);
                    return "Обновление данных";
                }
            } else {
                if($bankForm == true) {
                    Yii::$app->session->setFlash('success', "Данные вашего аккаунта успешно обновлены.");
                    return $this->redirect(['user/update']);
                } else {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', Html::errorSummary($model));
        }

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Изменить данные #".$id,
                'content'=>$this->renderAjax($page, $params),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        } else {
            return $this->render($page, $params);
        }
    }

    /**
     * Delete an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null)
            return $model;
        throw new NotFoundHttpException(self::errorCode()[404]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBank($id)
    {
        if (($model = Userbank::findOne($id)) !== null)
            return $model;
        throw new NotFoundHttpException(self::errorCode()[404]);
    }

    /**
     * Список ролей в зависимости от пользователя
     * @return array|string[]
     */
    private function getRoles()
    {
        $roles = ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'name');

        if( \Yii::$app->user->can('Руководитель продаж')
            && !\Yii::$app->user->can('Администратор')
        ){
            $roles = [
                "Копирайтер" => "Копирайтер",
                "Базонаборщик" => "Базонаборщик",
                "Менеджер по продажам" => "Менеджер по продажам",
            ];
        }

        if(
            Yii::$app->user->can('Руководитель отдела отзывов')
            && !Yii::$app->user->can('Администратор')
        ){
            $roles = [
                "Руководитель отдела отзывов" => "Руководитель отдела отзывов",
                "Менеджер по отзывам" => "Менеджер по отзывам",
                "Контроллер" => "Контроллер",
                "Исполнитель SERM" => "Исполнитель SERM",
            ];
        }

        if( \Yii::$app->user->can('Куратор') ){
            $roles = [
                "Исполнитель SERM" => "Исполнитель SERM",
            ];
        }
        return $roles;
    }

    /**
     * Вход в систему под другим пользователем
     * @param $id
     * @return Response
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionLoginOtherUser($id)
    {
        if ( !Yii::$app->user->can('LoginAsUser') )
            throw new HttpException(403, self::errorCode()[403]);

        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }

        $session->set('before_user_id', Yii::$app->user->id);

        $user = $this->findModel($id);
        Yii::$app->user->login($user, 0);

        return $this->goHome();
    }
}
