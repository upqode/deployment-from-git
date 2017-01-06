<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\UserForm;
use app\models\Logs;
use app\models\Settings;
use app\models\Users;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $pageSize = Settings::getSettingValue(Settings::SETTING_SHOW_ELEMENTS_ON_PAGE, 25);

        $query = Users::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);
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
        /** @var Users $identity */
        $identity = Yii::$app->user->identity;

        if (!$identity->is_admin) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'У вас недостаточно прав для выполнения данного действия!',
            ]);

            return $this->redirect(['index']);
        }

        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Пользователь успешно создан!',
            ]);

            Logs::setLog(201, [':profile' => $model->email]);

            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Update user info
     *
     * @param integer $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $id = intval($id);
        $user = Users::findOne($id);

        /** @var Users $identity */
        $identity = Yii::$app->user->identity;

        if (!$user || !$identity->is_admin) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'У вас недостаточно прав для выполнения данного действия!',
            ]);

            return $this->redirect(['index']);
        }

        $model = new UserForm();
        $model->attributes = $user->attributes;
        $model->scenario = UserForm::SCENARIO_UPDATE;
        $model->email = $model->password = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->attributes = $model->attributes;
            $user->update();

            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Информация о пользователи обновлена!',
            ]);

            Logs::setLog(202, [':profile' => $user->getName()]);

            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Delete user
     *
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $id = intval($id);
        $user = Users::findOne($id);
        $userCount = Users::find()->count();

        /** @var Users $identity */
        $identity = Yii::$app->user->identity;

        if (!$identity->is_admin) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'У вас недостаточно прав для выполнения данного действия!',
            ]);
        } elseif ($user && $userCount > 1 && $user->delete()) {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Пользователь успешно удален!',
            ]);

            Logs::setLog(203, [':profile' => $user->getName()]);
        } else {
            Yii::$app->session->setFlash('userOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'При удаление пользователя возникли проблемы!',
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * User settings
     *
     * @return string|\yii\web\Response
     */
    public function actionSettings()
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;

        $model_settings = new UserForm();
        $model_settings->name = $user->name;
        $model_settings->scenario = $model_settings::SCENARIO_USER_INFO;

        $model_password = new UserForm();
        $model_password->scenario = $model_password::SCENARIO_USER_PASS;

        // change settings
        if (Yii::$app->request->post('type') == $model_settings::SCENARIO_USER_INFO) {
            if ($model_settings->load(Yii::$app->request->post()) && $model_settings->validate()) {
                $user->name = $model_settings->name;
                $user->update();

                Yii::$app->session->setFlash('userOperation', [
                    'type' => 'alert-success',
                    'icon' => 'mdi mdi-check',
                    'title' => 'Success!',
                    'message' => 'Информация успешно обновлена!',
                ]);

                return $this->redirect(['index']);
            }
        }

        // change password
        if (Yii::$app->request->post('type') === $model_password::SCENARIO_USER_PASS) {
            if ($model_password->load(Yii::$app->request->post()) && $model_password->validate()) {
                if ($user->validatePassword($model_password->old_password)) {
                    $user->password = Yii::$app->security->generatePasswordHash($model_password->password);
                    $user->update();

                    Yii::$app->session->setFlash('userOperation', [
                        'type' => 'alert-success',
                        'icon' => 'mdi mdi-check',
                        'title' => 'Success!',
                        'message' => 'Пароль изменен!',
                    ]);

                    return $this->redirect(['index']);
                } else {
                    $model_password->addError('old_password', 'Old password is incorrect!');
                }
            }
        }

        return $this->render('settings', [
            'model_settings' => $model_settings,
            'model_password' => $model_password,
        ]);
    }

    /**
     * Latest user activity
     *
     * @param int $id
     * @return string
     */
    public function actionActivity($id)
    {
        $logs = Logs::find()->where(['user_id' => intval($id)])->limit(50)->orderBy(['id' => SORT_DESC])->all();

        return $this->render('activity', ['logs' => $logs]);
    }

}