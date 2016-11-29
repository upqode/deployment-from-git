<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="be-wrapper be-fixed-sidebar">
    <nav class="navbar navbar-default navbar-fixed-top be-top-header">
        <div class="container-fluid">
            <div class="navbar-header"><a href="#" class="navbar-brand"></a></div>
            <div class="be-right-navbar">
                <ul class="nav navbar-nav navbar-right be-user-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                            <?= Html::img('/img/avatar.png'); ?>
                            <span class="user-name">i3y3ik@gmail.com</span>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <div class="user-info">
                                    <div class="user-name">i3y3ik@gmail.com</div>
                                </div>
                            </li>
                            <li><a href="#"><span class="icon mdi mdi-settings"></span> Settings</a></li>
                            <li><a href="#"><span class="icon mdi mdi-power"></span> Logout</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="page-title"><span><?= Html::encode($this->title) ?></span></div>
                <ul class="nav navbar-nav navbar-right be-icons-nav">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-notifications"></span><span class="indicator"></span></a>
                        <ul class="dropdown-menu be-notifications">
                            <li>
                                <div class="title">Notifications <span class="badge">3</span></div>
                                <div class="list">
                                    <div class="be-scroller">
                                        <div class="content">
                                            <ul>
                                                <li class="notification notification-unread">
                                                    <a href="#">
                                                        <div class="image"><?= Html::img('/img/avatar.png'); ?></div>
                                                        <div class="notification-info">
                                                            <div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation to join the team.</div>
                                                            <span class="date">2 min ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="notification">
                                                    <a href="#">
                                                        <div class="image"><?= Html::img('/img/avatar.png'); ?></div>
                                                        <div class="notification-info">
                                                            <div class="text"><span class="user-name">Joel King</span> is now following you</div>
                                                            <span class="date">2 days ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="notification">
                                                    <a href="#">
                                                        <div class="image"><?= Html::img('/img/avatar.png'); ?></div>
                                                        <div class="notification-info">
                                                            <div class="text"><span class="user-name">John Doe</span> is watching your main repository</div>
                                                            <span class="date">2 days ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="notification">
                                                    <a href="#">
                                                        <div class="image"><?= Html::img('/img/avatar.png'); ?></div>
                                                        <div class="notification-info">
                                                            <span class="text"><span class="user-name">Emily Carter</span> is now following you</span>
                                                            <span class="date">5 days ago</span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer"><a href="#">View all notifications</a></div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-apps"></span></a>
                        <ul class="dropdown-menu be-connections">
                            <li>
                                <div class="list">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-xs-6"><a href="#" class="connection-item"><?= Html::img('/img/github.png'); ?><span>Подключить<br>GitHub</span></a></div>
                                            <div class="col-xs-6"><a href="#" class="connection-item"><?= Html::img('/img/bitbucket.png'); ?><span>Подключить<br>BitBucket</span></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer"><a href="#">More</a></div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="be-left-sidebar">
        <div class="left-sidebar-wrapper">
            <a href="#" class="left-sidebar-toggle">Site menu</a>

            <div class="left-sidebar-spacer">
                <div class="left-sidebar-scroll">
                    <div class="left-sidebar-content">
                        <ul class="sidebar-elements">
                            <li class="divider">Menu</li>
                            <li class="active"><a href="<?= Url::toRoute(['/admin/index']); ?>"><i class="icon mdi mdi-chart"></i><span>Statistics</span></a></li>
                            <li><a href="<?= Url::toRoute(['/repository/index']); ?>"><i class="icon mdi mdi-storage"></i><span>Repositories</span></a></li>
                            <li><a href="<?= Url::toRoute(['/backup/index']); ?>"><i class="icon mdi mdi-archive"></i><span>Backups</span></a></li>
                            <li><a href="<?= Url::toRoute(['/admin/setting']); ?>"><i class="icon mdi mdi-settings"></i><span>Settings</span></a></li>
                            <li><a href="<?= Url::toRoute(['/user/index']); ?>"><i class="icon mdi mdi-accounts-list-alt"></i><span>Users</span></a></li>
                            <li><a href="<?= Url::toRoute(['/admin/cron']); ?>"><i class="icon mdi mdi-time-interval"></i><span>Cron</span></a></li>
                            <li><a href="<?= Url::toRoute(['/log/index']); ?>"><i class="icon mdi mdi-file"></i><span>Logs</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="be-content">
        <div class="main-content container-fluid">
            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
