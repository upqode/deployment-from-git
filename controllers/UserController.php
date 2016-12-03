<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\UserForm;
use app\models\Users;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;

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
            Yii::$app->session->setFlash('userOperation', 'Пользователь успешно добавлен.');
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

}