<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Backups;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'install' => ['POST'],
                    'delete' => ['POST'],
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

    /**
     * Show backups list this repository
     *
     * @param integer $id
     * @return string|\yii\web\Response
     */
    public function actionRepository($id)
    {
        $backups = Backups::findAll(['repository_id' => intval($id)]);

        if (!$backups) {
            Yii::$app->session->setFlash('backupOperation', [
                'type' => 'alert-primary',
                'icon' => 'mdi mdi-info-outline',
                'title' => 'Info!',
                'message' => 'Backups to this repository has not yet been made!',
            ]);

            return $this->redirect(['index']);
        }

        return $this->render('repository', ['backups' => $backups]);
    }

    /**
     * Download backup file
     *
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionDownload($id)
    {
        $backup = Backups::findOne(intval($id));

        if ($backup) {
            $filename = $backup->getBackupPath($backup->repository->remote_path, $backup->time);
            if (file_exists($filename)) {
                Yii::$app->response->sendFile($filename)->send();
            }
        }

        Yii::$app->session->setFlash('backupOperation', [
            'type' => 'alert-danger',
            'icon' => 'mdi mdi-close-circle-o',
            'title' => 'Danger!',
            'message' => 'Backup file is not available!',
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Install selected backup
     *
     * @return string
     */
    public function actionInstall()
    {
        $id = Yii::$app->request->post('id');
        $backup = Backups::findOne(intval($id));

        if ($backup && $backup->installBackup()) {
            return Json::encode(['message' => 'Backup successful restored!', 'type' => 'success']);
        }

        return Json::encode(['message' => 'Backup is not restored!', 'type' => 'error']);
    }

    /**
     * Remove backup
     *
     * @return string
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $backup = Backups::findOne(intval($id));

        if ($backup && $backup->deleteBackup()) {
            return Json::encode(['message' => 'Backup successful deleted!', 'type' => 'success']);
        }

        return Json::encode(['message' => 'Backup is not deleted!', 'type' => 'error']);
    }

}