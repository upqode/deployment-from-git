<?php

/* @var $this yii\web\View */
/* @var $counters array */
/* @var $logs array */
/* @var $log \app\models\Logs */

use yii\helpers\Html;

$this->title = 'Dashboard';
$this->registerJsFile('/js/app-dashboard.js', ['depends' => \app\assets\AppAsset::className()]);
$this->registerJsFile('/library/count-up/countUp.min.js', ['depends' => \app\assets\AppAsset::className()]);
$this->registerJsFile('/library/jquery.sparkline/jquery.sparkline.min.js', ['depends' => \app\assets\AppAsset::className()]);
?>
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-4">
        <div class="widget widget-tile">
            <div id="spark1" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Users</div>
                <div class="value">
                    <span class="indicator indicator-equal mdi mdi-chevron-right"></span>
                    <span data-toggle="counter" data-end="<?= $counters['users'] ?>" class="number">0</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-4">
        <div class="widget widget-tile">
            <div id="spark3" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Repositories</div>
                <div class="value">
                    <span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                    <span data-toggle="counter" data-end="<?= $counters['repositories'] ?>" class="number">0</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-4">
        <div class="widget widget-tile">
            <div id="spark4" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Backups</div>
                <div class="value">
                    <span class="indicator indicator-negative mdi mdi-chevron-right"></span>
                    <span data-toggle="counter" data-end="<?= $counters['backups'] ?>" class="number">0</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($logs): ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Last Activity</div>
                <div class="panel-body">
                    <ul class="user-timeline user-timeline-compact">
                        <?php foreach ($logs as $log): ?>
                            <li>
                                <div class="user-timeline-date"><?= Yii::$app->formatter->asDatetime($log->time); ?></div>
                                <div class="user-timeline-title"><?= Html::decode($log->action); ?></div>
                                <div class="user-timeline-description">Vestibulum lectus nulla, maximus in eros non, tristique.</div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
