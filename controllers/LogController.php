<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Logs;
use yii\data\Pagination;
use yii\filters\AccessControl;

class LogController extends BaseController
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
     * Logs list
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Logs::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $logs = $query->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', [
            'pages' => $pages,
            'logs' => $logs,
        ]);
    }

}