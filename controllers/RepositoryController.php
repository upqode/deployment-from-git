<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\BitBucket;
use app\components\FileSystem;
use app\components\GitHub;
use app\models\forms\RepositoryForm;
use app\models\forms\ServiceForm;
use app\models\Repositories;
use app\models\Services;
use app\models\Users;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\data\Pagination;
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Get repository list
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Repositories::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 25]);
        $repositories = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'repositories' => $repositories,
            'pages' => $pages,
        ]);
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
        $model->scenario = $model::SCENARIO_CREATE;

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

    /**
     * Edit repository
     *
     * @param integer $id
     * @return array|string|Response
     */
    public function actionSettings($id)
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;
        $repository = Repositories::findOne(intval($id));

        if (!$repository || (!$user->is_admin && $user->id != $repository->user_id)) {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'Что-то пошло не так!',
            ]);

            return $this->redirect(['index']);
        }

        $model = new RepositoryForm();
        $model->attributes = $repository->attributes;
        $model->scenario = $model::SCENARIO_UPDATE;
        $folder_list = FileSystem::getDirInfo($model->local_path);

        // ajax model validate
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        // update repository
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $repository->attributes = $model->attributes;
            $repository->update();

            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Repository updated!',
            ]);

            return $this->redirect(['index']);
        }

        return $this->render('settings', [
            'model' => $model,
            'folder_list' => $folder_list,
        ]);
    }

    /**
     * Remove repository from system
     *
     * @param integer $id
     * @return Response
     */
    public function actionDelete($id)
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;
        $repository = Repositories::findOne(intval($id));

        if (($user->is_admin || $user->id == $repository->user_id) && $repository && $repository->delete()) {
            // @todo: need remove all backups this repository and other data

            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Repository removed!',
            ]);
        } else {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'У вас недостаточно прав для выполнения данного действия!',
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Get repository commits
     *
     * @param integer $id - Repository ID
     * @return string|Response
     */
    public function actionCommits($id)
    {
        $repository = Repositories::findOne(intval($id));

        if (!$repository) {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'Repository not found!',
            ]);

            return $this->redirect(['index']);
        }

        $commits = $repository->getRepositoryCommits();

        return $this->render('commits', [
            'commits' => $commits,
            'repository' => $repository,
        ]);
    }

}