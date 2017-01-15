<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Backups;
use app\models\forms\SettingsForm;
use app\models\Logs;
use app\models\Repositories;
use app\models\Settings;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;

class AdminController extends BaseController
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
     * Dashboard
     *
     * @return string
     */
    public function actionIndex()
    {
        $logs = Logs::find()->limit(10)->orderBy(['id' => SORT_DESC])->all();
        $counters = [
            'users' => Users::find()->count(),
            'backups' => Backups::find()->count(),
            'repositories' => Repositories::find()->count(),
        ];

        return $this->render('index', [
            'logs' => $logs,
            'counters' => $counters,
        ]);
    }

    /**
     * Updated system settings
     *
     * @return string|\yii\web\Response
     */
    public function actionSettings()
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;

        if (!$user->is_admin) {
            return $this->goBack();
        }

        $model = new SettingsForm();

        // get system options
        $model->admin_email = Settings::getSettingValue(Settings::SETTING_ADMIN_EMAIL);
        $model->backups_dir = Settings::getSettingValue(Settings::SETTING_BACKUPS_DIR);
        $model->show_elements_on_page = Settings::getSettingValue(Settings::SETTING_SHOW_ELEMENTS_ON_PAGE);
        $model->remove_logs_after_days = Settings::getSettingValue(Settings::SETTING_REMOVE_LOGS_AFTER_DAYS);
        $model->backups_max_count_copy = Settings::getSettingValue(Settings::SETTING_BACKUPS_MAX_COUNT_COPY);
        $model->remove_backups_after_days = Settings::getSettingValue(Settings::SETTING_REMOVE_BACKUPS_AFTER_DAYS);

        // update options
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('settingsHasBeenUpdated');

            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }

    /**
     * Page: how use cron?
     *
     * @return string
     */
    public function actionCron()
    {
        return $this->render('cron');
    }

}