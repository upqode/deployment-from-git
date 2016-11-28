<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\InstallForm;
use app\models\forms\LoginForm;
use app\models\forms\RestorePassword;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'restore-password', 'reset-password'],
                'rules' => [
                    ['actions' => ['logout'], 'allow' => true, 'roles' => ['@']],
                    ['actions' => ['login', 'restore-password', 'reset-password'], 'allow' => true, 'roles' => ['?']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Homepage
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/admin/index']);
        }

        if (!Users::find()->count()) { // @todo: need method
            return $this->redirect(['install']);
        }

        return $this->redirect(['login']);
    }

    /**
     * Installing db schema and create admin (only for first open)
     *
     * @return string|\yii\web\Response
     */
    public function actionInstall()
    {
        $hasUser = Users::find()->count();

        // @todo: need more check. need method
        if ($hasUser) {
            return $this->goHome();
        }

        $this->layout = BaseController::LAYOUT_UNAUTHORIZED;
        $model = new InstallForm();

        if ($model->load(Yii::$app->request->post()) && $model->install()) {
            return $this->redirect(['login']);
        }

        return $this->render('install', ['model' => $model]);
    }

    /**
     * Login action
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = BaseController::LAYOUT_UNAUTHORIZED;
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/admin/index']);
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Restore password (send reset link on user email)
     *
     * @return string|\yii\web\Response
     */
    public function actionRestorePassword()
    {
        $this->layout = BaseController::LAYOUT_UNAUTHORIZED;

        $model = new RestorePassword();
        $model->scenario = RestorePassword::SCENARIO_RESTORE;

        if ($model->load(Yii::$app->request->post()) && $model->restore()) {
            Yii::$app->session->setFlash('successRestorePassword');
            return $this->refresh();
        }

        return $this->render('restore-password', ['model' => $model]);
    }

    /**
     * Reset password (change password)
     *
     * @param string $email
     * @param string $key
     * @return string|\yii\web\Response
     */
    public function actionResetPassword($email, $key)
    {
        $email = urldecode($email);
        $user = Users::find()->where(['email' => $email, 'reset_key' => $key])->count();

        if (!$user) {
            return $this->goHome();
        }

        $this->layout = BaseController::LAYOUT_UNAUTHORIZED;

        $model = new RestorePassword();
        $model->scenario = RestorePassword::SCENARIO_RESET;

        if ($model->load(Yii::$app->request->post()) && $model->reset($email)) {
            Yii::$app->session->setFlash('successResetPassword');
            return $this->redirect(['login']);
        }

        return $this->render('reset-password', ['model' => $model]);
    }

}
