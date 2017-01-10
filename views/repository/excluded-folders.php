<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $excluded_folders array */
/* @var $excluded_folder \app\models\ExcludeFolders */

$this->title = 'Excluded folders';
$this->registerCssFile('/library/sweetalert/sweetalert.css');
$this->registerJsFile('/library/sweetalert/sweetalert.min.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('/js/repository.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="row">
    <div class="col-md-12">
        <?php if (Yii::$app->session->hasFlash('folderHasBeenExcluded')): ?>
            <div role="alert" class="alert alert-contrast alert-success alert-dismissible">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <span aria-hidden="true" class="mdi mdi-close"></span>
                    </button>
                    <strong>Success!</strong> Folder has been excluded.
                </div>
            </div>
        <?php endif; ?>
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="tools">
                    <a href="<?= Url::toRoute(['exclude-folders', 'id' => Yii::$app->request->get('id')]); ?>">
                        <span class="icon mdi mdi-collection-plus"></span>
                    </a>
                </div>
                <div class="title"><?= Html::decode($this->title); ?></div>
            </div>
            <div class="panel-body table-responsive">
                <?php if ($excluded_folders): ?>
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th>Folder</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="no-border-x">
                        <?php foreach ($excluded_folders as $excluded_folder): ?>
                            <tr class="ajax-ef-row-id" data-id="<?= $excluded_folder->id ?>">
                                <td><?= $excluded_folder->folder ?></td>
                                <td class="actions">
                                    <a href="#" class="icon ajax-ef-delete" data-id="<?= $excluded_folder->id ?>"><i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center"><strong>Repository not found or not excluded folder in this repository!</strong></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
