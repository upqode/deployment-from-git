<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Services';
?>
<?php if (Yii::$app->session->hasFlash('serviceOperation')): ?>
    <div class="row">
        <div class="col-sm-12">
            <?php $flash = Yii::$app->session->getFlash('serviceOperation'); ?>
            <div role="alert" class="alert alert-contrast <?= $flash['type'] ?> alert-dismissible">
                <div class="icon"><span class="<?= $flash['icon'] ?>"></span></div>
                <div class="message">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <span aria-hidden="true" class="mdi mdi-close"></span>
                    </button>
                    <strong><?= $flash['title'] ?></strong> <?= $flash['message'] ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="user-profile">
    <div class="row sm-mt-50">
        <div class="col-md-4">
            <div class="user-display">
                <div class="user-display-bottom">
                    <div class="user-display-avatar"><?= Html::img('/img/github-big.png'); ?></div>
                    <div class="user-display-info">
                        <div class="name">UpQode Company</div>
                        <div class="nick"><span class="mdi mdi-dns"></span> GitHub</div>
                    </div>
                    <div class="row user-display-details">
                        <div class="col-xs-4">
                            <div class="title">Created</div>
                            <div class="counter">12.12.2016</div>
                        </div>
                        <div class="col-xs-4">
                            <div class="title">Repositories</div>
                            <div class="counter">26</div>
                        </div>
                        <div class="col-xs-4">
                            <div class="title">Status</div>
                            <div class="btn-group btn-group-sm btn-hspace">
                                <button type="button" data-toggle="dropdown" class="btn btn-rounded btn-success dropdown-toggle" aria-expanded="false">
                                    Success <span class="icon-dropdown mdi mdi-chevron-down"></span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="#">Disable</a></li>
                                    <li><a href="#">Settings</a></li>
                                    <li><a href="#">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
