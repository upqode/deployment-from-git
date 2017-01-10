<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\ExcludeFoldersForm */
/* @var $folder_list array */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Exclude Folders';
$this->registerJsFile('/js/repository.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading panel-heading-divider">
                <?= Html::encode($this->title); ?>
                <span class="panel-subtitle">This is the default bootstrap form layout</span>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>

                <?= Html::hiddenInput('local_path', $folder_list['path'], ['id' => 'local-path']); ?>

                <?= $form->field($model, 'folder', [
                    'template' => '{label}<div class="input-group">{input}<span class="input-group-btn"><button type="button" id="select-local-path-btn" class="btn btn-primary">Select</button></span></div>{error}',
                ])->textInput(['id' => 'local-path-visible-field']); ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-space btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div id="select-local-path-modal" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-primary in">
    <div class="modal-dialog custom-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close">
                    <span class="mdi mdi-close"></span>
                </button>
                <h3 class="modal-title">Please, select local path...</h3>
            </div>
            <div class="modal-body">
                <div id="dir-list-block" class="aside-nav">
                    <div class="spinner hidden">
                        <span class="dot1"></span><span class="dot2"></span><span class="dot3"></span>
                    </div>
                    <ul class="nav nav-pills nav-stacked dir-list">
                        <?php foreach ($folder_list['dir_list'] as $folder): ?>
                            <li>
                                <a href="#" data-dir="/<?= $folder ?>" class="change-dir">
                                    <i class="mdi mdi-folder"></i> <?= $folder ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default md-close">Cancel</button>
                <button type="button" class="btn btn-primary" id="select-current-dir">Select current dir</button>
            </div>
        </div>
    </div>
</div>
