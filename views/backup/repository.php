<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

/* @var $backup \app\models\Backups */
/* @var $backups array */

$this->title = 'Repository backups';
$this->registerCssFile('/library/sweetalert/sweetalert.css');
$this->registerJsFile('/library/sweetalert/sweetalert.min.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('/js/backups.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <?php if ($backups): ?>
                <div class="panel-heading">
                    <div class="title"><?= $backups[0]->repository->name; ?></div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th>Date created</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="no-border-x">
                        <?php foreach ($backups as $backup): ?>
                            <tr class="ajax-row" data-id="<?= $backup->id ?>">
                                <td><?= Yii::$app->formatter->asDatetime($backup->time); ?></td>
                                <td class="actions">
                                    <a href="#" class="icon xs-mr-10 ajax-backup-install" data-id="<?= $backup->id ?>"><i class="mdi mdi-upload"></i></a>
                                    <a href="<?= Url::toRoute(['download', 'id' => $backup->id]); ?>" class="icon xs-mr-10"><i class="mdi mdi-download"></i></a>
                                    <a href="#" class="icon ajax-backup-delete" data-id="<?= $backup->id ?>"><i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
