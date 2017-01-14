<?php

namespace app\commands;

use app\components\Cron;
use yii\console\Controller;

class CronController extends Controller
{

    public $cronAction;

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['cronAction']);
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), ['a' => 'cronAction']);
    }

    /**
     * Get cron task and run it
     */
    public function actionIndex()
    {
        Cron::run($this->cronAction);
    }

}