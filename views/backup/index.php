<?php

/* @var $this yii\web\View */
/* @var $backups array */

use yii\helpers\Html;

$this->title = 'Backups List';
?>
<div class="row">
    <div class="col-md-12">
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
                                                <li><?= Html::a('Install last backup', ['install-last', 'id' => $backup['repository_id']]) ?></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
