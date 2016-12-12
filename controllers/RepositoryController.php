<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\BitBucket;
use app\components\FileSystem;
use app\components\GitHub;
use app\models\forms\RepositoryForm;
use app\models\forms\ServiceForm;
use app\models\Services;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;

class RepositoryController extends BaseController
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
                    'get-for-remote-path' => ['POST'],
                    'get-local-path' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Register new repository in system
     *
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        /** @var Services $service */
        $model = new RepositoryForm();
        $services = Services::find()->all();
        $folder_list = FileSystem::getDirInfo();

        $service_list = array();

        // normalize service for select: Service name: Username
        foreach ($services as $service) {
            $service_list[$service->id] = $service->getServiceName() .': '. $service->username;
        }

        // ajax model validate
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        // save model
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Repository has been added in system!',
            ]);

            return $this->redirect(['index']);
        }

        return $this->render('add', [
            'model' => $model,
            'folder_list' => $folder_list,
            'service_list' => $service_list,
        ]);
    }

    /**
     * Get repository list for select on remote path
     *
     * @return string
     */
    public function actionGetForRemotePath()
    {
        $output = $repositories_list = array();

        if (Yii::$app->request->post('depdrop_parents')) {
            $parents = Yii::$app->request->post('depdrop_parents');

            if (isset($parents[0]) && is_numeric($parents[0])) {
                $service = Services::findOne(intval($parents[0]));

                if ($service) {
                    if ($service->type === ServiceForm::TYPE_GITHUB) {
                        $repositories_list = GitHub::getRepositoriesList($service->username, $service->access_token);
                    } elseif ($service->type === ServiceForm::TYPE_BITBUCKET) {
                        $repositories_list = BitBucket::getRepositoriesList($service->username, $service->access_token);
                    }
                }

                if ($repositories_list) {
                    foreach ($repositories_list as $repository) {
                        $output[] = ['id' => $repository['full_name'], 'name' => $repository['name']];
                    }
                }
            }
        }

        return Json::encode(['output'=> $output, 'selected' => '']);
    }

    /**
     * Get directory list for local path
     *
     * @return string
     */
    public function actionGetDirInfo()
    {
        $dir = Yii::$app->request->post('dir');
        $folder_list = FileSystem::getDirInfo($dir);

        return Json::encode($folder_list);
    }

}