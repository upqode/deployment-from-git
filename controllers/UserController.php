<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\UserForm;
use app\models\Users;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends BaseController
{

    public $layout = BaseController::LAYOUT_AUTHORIZED;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Get users list
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Users::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 25]);
        $users = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'pages' => $pages,
            'users' => $users,
        ]);
    }

    /**
     * Create new user
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Пользователь успешно удален!',
            ]);

            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Delete user
     *
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $id = intval($id);
        $user = Users::findOne($id);
        $userCount = Users::find()->count();

        if ($user && $userCount > 1 && $user->delete()) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Пользователь успешно удален!',
            ]);
        } else {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'При удаление пользователя возникли проблемы!',
            ]);
        }

        return $this->redirect(['index']);
    }

}