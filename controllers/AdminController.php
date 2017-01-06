<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\SettingsForm;
use app\models\Settings;
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Updated system settings
     *
     * @return string|\yii\web\Response
     */
    public function actionSetting()
    {
        $model = new SettingsForm();

        // get system options
        $model->admin_email = Settings::getSettingValue(Settings::SETTING_ADMIN_EMAIL);
        $model->backups_dir = Settings::getSettingValue(Settings::SETTING_BACKUPS_DIR);
        $model->show_elements_on_page = Settings::getSettingValue(Settings::SETTING_SHOW_ELEMENTS_ON_PAGE);
        $model->remove_logs_after_days = Settings::getSettingValue(Settings::SETTING_REMOVE_LOGS_AFTER_DAYS);
        $model->backups_max_count_copy = Settings::getSettingValue(Settings::SETTING_BACKUPS_MAX_COUNT_COPY);

        // update options
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('settingsHasBeenUpdated');

            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }

    public function actionCron()
    {
        return $this->render('cron');
    }

}