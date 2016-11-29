<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Dashboard';
$this->registerJsFile('/js/app-dashboard.js', ['depends' => \app\assets\AppAsset::className()]);
$this->registerJsFile('/library/count-up/countUp.min.js', ['depends' => \app\assets\AppAsset::className()]);
$this->registerJsFile('/library/jquery.sparkline/jquery.sparkline.min.js', ['depends' => \app\assets\AppAsset::className()]);
?>
<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="widget widget-tile">
            <div id="spark1" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Users</div>
                <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="113" class="number">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="widget widget-tile">
            <div id="spark2" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Cron jobs</div>
                <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="80" class="number">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="widget widget-tile">
            <div id="spark3" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Repositories</div>
                <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="532" class="number">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="widget widget-tile">
            <div id="spark4" class="chart sparkline"></div>
            <div class="data-info">
                <div class="desc">Backups</div>
                <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="113" class="number">0</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Last Activity</div>
            <div class="panel-body">
                <ul class="user-timeline user-timeline-compact">
                    <li class="latest">
                        <div class="user-timeline-date">Just Now</div>
                        <div class="user-timeline-title">Create New Page</div>
                        <div class="user-timeline-description">Vestibulum lectus nulla, maximus in eros non, tristique.</div>
                    </li>
                    <li>
                        <div class="user-timeline-date">Today - 15:35</div>
                        <div class="user-timeline-title">Back Up Theme</div>
                        <div class="user-timeline-description">Vestibulum lectus nulla, maximus in eros non, tristique.</div>
                    </li>
                    <li>
                        <div class="user-timeline-date">Yesterday - 10:41</div>
                        <div class="user-timeline-title">Changes In The Structure</div>
                        <div class="user-timeline-description">Vestibulum lectus nulla, maximus in eros non, tristique.</div>
                    </li>
                    <li>
                        <div class="user-timeline-date">Yesterday - 3:02</div>
                        <div class="user-timeline-title">Fix the Sidebar</div>
                        <div class="user-timeline-description">Vestibulum lectus nulla, maximus in eros non, tristique.</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="tools"><span class="icon mdi mdi-download"></span><span class="icon mdi mdi-more-vert"></span></div>
                <div class="title">Last Commits</div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:37%;">User</th>
                        <th style="width:36%;">Commit</th>
                        <th>Date</th>
                        <th class="actions"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Penelope Thornton</td>
                        <td>Topbar dropdown style</td>
                        <td>Aug 16, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Benji Harper</td>
                        <td>Left sidebar adjusments</td>
                        <td>Jul 15, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Justine Myranda</td>
                        <td>Main structure markup</td>
                        <td>Jul 28, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Sherwood Clifford</td>
                        <td>Initial commit</td>
                        <td>Jun 30, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
