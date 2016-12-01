<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Users;
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

}