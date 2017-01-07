<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\forms\ServiceForm;
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
            <div class="navbar-header"><a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand"></a></div>
            <div class="be-right-navbar">
                <ul class="nav navbar-nav navbar-right be-user-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                            <?= Html::img('/img/avatar.png'); ?>
                            <span class="user-name"><?= Yii::$app->user->identity->getName(); ?></span>
                        </a>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <div class="user-info">
                                    <div class="user-name"><?= Yii::$app->user->identity->email ?></div>
                                </div>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/user/settings']); ?>">
                                    <span class="icon mdi mdi-settings"></span> Settings
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['/site/logout']); ?>" data-method="post">
                                    <span class="icon mdi mdi-power"></span> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="page-title"><span><?= Html::encode($this->title) ?></span></div>
                <ul class="nav navbar-nav navbar-right be-icons-nav">
                    <?= \app\models\Logs::getLastNotifications(); ?>

                    <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="icon mdi mdi-apps"></span></a>
                        <ul class="dropdown-menu be-connections">
                            <li>
                                <div class="list">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-xs-6"><a href="<?= Url::toRoute(['/services/add', 'type' => ServiceForm::TYPE_GITHUB]); ?>" class="connection-item"><?= Html::img('/img/github.png'); ?><span>Подключить<br>GitHub</span></a></div>
                                            <div class="col-xs-6"><a href="<?= Url::toRoute(['/services/add', 'type' => ServiceForm::TYPE_BITBUCKET]); ?>" class="connection-item"><?= Html::img('/img/bitbucket.png'); ?><span>Подключить<br>BitBucket</span></a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer"><a href="<?= Url::toRoute(['/services']); ?>">See all</a></div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="be-left-sidebar">
        <div class="left-sidebar-wrapper">
            <a href="#" class="left-sidebar-toggle">Main menu</a>

            <div class="left-sidebar-spacer">
                <div class="left-sidebar-scroll">
                    <div class="left-sidebar-content">
                        <?= \app\widgets\Menu::widget([
                            'options' => ['class' => 'sidebar-elements'],
                            'items' => [
                                ['label' => 'Menu', 'options' => ['class' => 'divider']],
                                ['label' => 'Statistics', 'icon' => 'icon mdi mdi-chart', 'url' => ['/admin/index']],
                                ['label' => 'Repositories', 'icon' => 'icon mdi mdi-storage', 'url' => ['/repository/index']],
                                ['label' => 'Backups', 'icon' => 'icon mdi mdi-archive', 'url' => ['/backup/index']],
                                ['label' => 'Settings', 'icon' => 'icon mdi mdi-settings', 'url' => ['/admin/settings']],
                                ['label' => 'Users', 'icon' => 'icon mdi mdi-accounts-list-alt', 'url' => ['/user/index']],
                                ['label' => 'Cron', 'icon' => 'icon mdi mdi-time-interval', 'url' => ['/admin/cron']],
                                ['label' => 'Logs', 'icon' => 'icon mdi mdi-file', 'url' => ['/log/index']],
                            ],
                        ]); ?>
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
