<?php

/* @var $this yii\web\View */
/* @var $backups array */

use yii\helpers\Html;

$this->title = 'Backups List';
$this->registerCssFile('/library/sweetalert/sweetalert.css');
$this->registerJsFile('/library/sweetalert/sweetalert.min.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('/js/backups.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="row">
    <div class="col-md-12">
        <?php if (Yii::$app->session->hasFlash('backupOperation')): ?>
            <?php $flash = Yii::$app->session->getFlash('backupOperation'); ?>
            <div role="alert" class="alert alert-contrast <?= $flash['type'] ?> alert-dismissible">
                <div class="icon"><span class="<?= $flash['icon'] ?>"></span></div>
                <div class="message">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <span aria-hidden="true" class="mdi mdi-close"></span>
                    </button>
                    <strong><?= $flash['title'] ?></strong> <?= $flash['message'] ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="panel panel-default panel-table">
            <div class="panel-heading">Repository List
                <div class="tools"></div>
            </div>
            <div class="panel-body">
                <div class="noSwipe">
                    <?php if (!empty($backups)): ?>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width:40%;">Repository</th>
                                <th style="width:20%;">Last backup date</th>
                                <th style="width:15%;">Backup count</th>
                                <th style="width:10%;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($backups as $backup): ?>
                                <tr>
                                    <td class="cell-detail"><span><?= $backup['repository_name']; ?></span></td>
                                    <td class="cell-detail">
                                        <span><?= Yii::$app->formatter->asDate($backup['time']); ?></span>
                                        <span class="cell-detail-description"><?= Yii::$app->formatter->asTime($backup['time']); ?></span>
                                    </td>
                                    <td class="cell-detail"><span><?= $backup['count']; ?></span></td>
                                    <td class="text-right">
                                        <div class="btn-group btn-hspace">
                                            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
                                                Actions <span class="icon-dropdown mdi mdi-chevron-down"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu pull-right">
                                                <li><?= Html::a('Backups list', ['repository', 'id' => $backup['repository_id']]) ?></li>
                                                <li>
                                                    <?= Html::a('Restore last backup', '#', [
                                                        'class' => 'ajax-backup-restore-last',
                                                        'data-id' => $backup['repository_id'],
                                                    ]) ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="lead text-center xs-mt-15">Backups is not defined!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
