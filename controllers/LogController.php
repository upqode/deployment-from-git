<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Logs;
use app\models\Settings;
use Yii;
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
        /** @var \app\models\Users $user */
        $user = Yii::$app->user->identity;
        $pageSize = Settings::getSettingValue(Settings::SETTING_SHOW_ELEMENTS_ON_PAGE, 50);
        $query = Logs::find();

        if (!$user->is_admin) {
            $query->where(['user_id' => $user->id]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
        $logs = $query->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', [
            'pages' => $pages,
            'logs' => $logs,
        ]);
    }

}