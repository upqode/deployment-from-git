<?php

/* @var $this yii\web\View */

use app\models\Settings;
use yii\helpers\Url;

$this->title = 'Cron';
$secret_key = Settings::getSettingValue(Settings::SETTING_CRON_SECRET_KEY);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">How used cron?</div>
            <div class="tab-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab" aria-expanded="false">Remove old logs</a></li>
                    <li><a href="#tab2" data-toggle="tab" aria-expanded="false">Remove old backups</a></li>
                    <li><a href="#tab3" data-toggle="tab" aria-expanded="true">Auto update repositories</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab-pane cont active">
                        <p>
                            <strong>Time:</strong> <span>Run once a day</span>
                        </p>

                        <strong>Command:</strong>
                        <div class="well">
                            <i>php <?= Yii::$app->getBasePath() ?>/yii cron -a=remove-old-logs > /dev/null 2>&1</i><br>
                            <span>or</span><br>
                            <i>wget -O - -q <?= Url::to(['/cron', 'action' => 'remove-old-logs', 'key' => $secret_key], true); ?> > /dev/null 2>&1</i>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane cont">
                        <p>
                            <strong>Time:</strong> <span>Run once a day</span>
                        </p>

                        <strong>Command:</strong>
                        <div class="well">
                            <i>php <?= Yii::$app->getBasePath() ?>/yii cron -a=remove-old-backups > /dev/null 2>&1</i><br>
                            <span>or</span><br>
                            <i>wget -O - -q <?= Url::to(['/cron', 'action' => 'remove-old-backups', 'key' => $secret_key], true); ?> > /dev/null 2>&1</i>
                        </div>
                    </div>
                    <div id="tab3" class="tab-pane">
                        <p>
                            <strong>Time:</strong> <span>Possible run several times a day</span><br>
                            <strong>Description:</strong> <span>Auto update repositories if need (only for repositories in which the enabled auto update and also enable repository service)</span>
                        </p>

                        <strong>Command:</strong>
                        <div class="well">
                            <i>php <?= Yii::$app->getBasePath() ?>/yii cron -a=auto-update-repositories > /dev/null 2>&1</i><br>
                            <span>or</span><br>
                            <i>wget -O - -q <?= Url::to(['/cron', 'action' => 'auto-update-repositories', 'key' => $secret_key], true); ?> > /dev/null 2>&1</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
