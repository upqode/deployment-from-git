<?php

namespace app\controllers;

use app\components\BaseController;
use app\components\Cron;
use app\models\Settings;

class CronController extends BaseController
{

    public $layout = false;

    /**
     * Get cron task and run it
     *
     * @param string $action
     * @param string $key
     */
    public function actionIndex($action, $key)
    {
        if (Settings::getSettingValue(Settings::SETTING_CRON_SECRET_KEY) === $key) {
            Cron::run($action);
        }
    }

}