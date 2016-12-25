<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Backups;
use yii\filters\AccessControl;

class BackupController extends BaseController
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
     * Show repository list with backup info
     *
     * @return string
     */
    public function actionIndex()
    {
        $backups = Backups::find()
            ->select([
                'DISTINCT(backups.repository_id) as repository_id',
                'COUNT(backups.repository_id) as count',
                'repositories.name as repository_name',
                'MAX(backups.time) as time',
            ])
            ->leftJoin('repositories', 'repositories.id = backups.repository_id')
            ->groupBy('repository_id')
            ->asArray()
            ->all();

        return $this->render('index', ['backups' => $backups]);
    }

}