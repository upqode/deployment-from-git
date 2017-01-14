<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\BitBucket;
use app\components\Deployment;
use app\components\FileSystem;
use app\components\GitHub;
use app\models\Backups;
use app\models\Commits;
use app\models\ExcludeFolders;
use app\models\forms\ExcludeFoldersForm;
use app\models\forms\RepositoryForm;
use app\models\forms\ServiceForm;
use app\models\Logs;
use app\models\Repositories;
use app\models\Services;
use app\models\Settings;
use app\models\Users;
use Yii;
use yii\base\ErrorException;
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
                    'delete-folder-from-excluded' => ['POST'],
                    'get-for-remote-path' => ['POST'],
                    'get-local-path' => ['POST'],
                    'install-commit' => ['POST'],
                    'delete' => ['POST'],
                    'backup' => ['POST'],
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
        $pageSize = Settings::getSettingValue(Settings::SETTING_SHOW_ELEMENTS_ON_PAGE, 25);

        $query = Repositories::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
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

            Logs::setLog(301, [':repository' => $model->remote_path]);

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

            Logs::setLog(302, [':repository' => $model->remote_path]);

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

            Logs::setLog(303, [':repository' => $repository->remote_path]);
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
        $service_name = strtolower($repository->service->getServiceName());

        return $this->render("commits-{$service_name}", [
            'commits' => $commits,
            'repository' => $repository,
        ]);
    }

    /**
     * Get repository branches
     *
     * @param integer $id - Repository ID
     * @return string|Response
     */
    public function actionBranches($id)
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

        $branches = $repository->getRepositoryBranches();
        $service_name = strtolower($repository->service->getServiceName());

        return $this->render("branches-{$service_name}", [
            'branches' => $branches,
            'repository' => $repository,
        ]);
    }

    /**
     * Install commit or branches
     *
     * @return string
     */
    public function actionInstallCommit()
    {
        $commit = Yii::$app->request->post('commit');
        $repository_id = Yii::$app->request->post('repository_id');

        $repository = Repositories::findOne(intval($repository_id));

        if (!$repository) {
            Yii::$app->response->setStatusCode(400);
            Yii::$app->response->content = 'Repository not found!';
            Yii::$app->response->send(); die;
        }

        $install_commit = Deployment::installCommit($repository, $commit);

        if (true === $install_commit) {
            Commits::saveInstalledCommitInfo($repository_id, $commit);
            Logs::setLog(304, [':commit' => $commit, ':repository' => $repository->remote_path]);

            return Json::encode(['result' => 'Commit has been installed!']);
        } else {
            Yii::$app->response->setStatusCode(400);
            Yii::$app->response->content = $install_commit;
            Yii::$app->response->send(); die;
        }
    }

    /**
     * Create backup this repository
     *
     * @param $id - repository id
     * @return Response
     */
    public function actionBackup($id)
    {
        $repository = Repositories::findOne(intval($id));

        $result = [
            'type' => 'alert-danger',
            'icon' => 'mdi mdi-close-circle-o',
            'title' => 'Danger!',
            'message' => 'Repository not found!',
        ];

        if ($repository) {
            try {
                if (Backups::createBackup($repository)) {
                    $result = [
                        'type' => 'alert-success',
                        'icon' => 'mdi mdi-check',
                        'title' => 'Success!',
                        'message' => 'Backup created!',
                    ];
                } else {
                    $result['message'] = 'Backup is not created!';
                }
            } catch (ErrorException $error) {
                $result['message'] = $error->getMessage();
            }
        }

        Yii::$app->session->setFlash('repositoryOperation', $result);
        return $this->redirect(['index']);
    }

    /**
     * Check repository on availability new version
     *
     * @param integer $id - repository id
     * @return Response
     */
    public function actionCheck($id)
    {
        $repository = Repositories::findOne(intval($id));

        if (!$repository) {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'Repository not found!',
            ]);
        }

        if ($repository->hasNewVersion()) {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-warning',
                'icon' => 'mdi mdi-alert-triangle',
                'title' => 'Warning!',
                'message' => 'You use not latest version!',
            ]);
        } else {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-primary',
                'icon' => 'mdi mdi-info-outline',
                'title' => 'Info!',
                'message' => 'You use the latest version!',
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Exclude folder
     *
     * @param int $id
     * @return string|Response
     */
    public function actionExcludeFolders($id)
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;
        $repository = Repositories::findOne(intval($id));

        if (!$repository || (!$user->is_admin && $user->id != $repository->user_id)) {
            Yii::$app->session->setFlash('repositoryOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'Bad request!',
            ]);

            return $this->redirect(['index']);
        }

        $folder_list = FileSystem::getDirInfo($repository->local_path);

        $model = new ExcludeFoldersForm();
        $model->local_path = $repository->local_path;
        $model->repository_id = $repository->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('folderHasBeenExcluded');

            return $this->redirect(['excluded-folders', 'id' => $id]);
        }

        return $this->render('exclude-folders', [
            'folder_list' => $folder_list,
            'model' => $model,
        ]);
    }

    /**
     * Excluded folder list
     *
     * @param int $id
     * @return string
     */
    public function actionExcludedFolders($id)
    {
        $excluded_folders = ExcludeFolders::findAll(['repository_id' => intval($id)]);

        return $this->render('excluded-folders', ['excluded_folders' => $excluded_folders]);
    }

    /**
     * Remove folder form excluded
     *
     * @return string
     */
    public function actionDeleteFolderFromExcluded()
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;
        $folder_id = Yii::$app->request->post('id');
        $excluded_folder = ExcludeFolders::findOne(intval($folder_id));

        if (($user->is_admin || $user->id == $excluded_folder->repository->user_id) && $excluded_folder && $excluded_folder->delete()) {
            return Json::encode(['message' => 'This folder has been success removed from excluded!', 'type' => 'success']);
        } else {
            return Json::encode(['message' => 'This folder cannot be removed from excluded!', 'type' => 'error']);
        }
    }

}