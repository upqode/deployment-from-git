<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\SettingsForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'System Settings';
?>
<div class="row">
    <div class="col-sm-12">
        <?php if (Yii::$app->session->hasFlash('settingsHasBeenUpdated')): ?>
            <div role="alert" class="alert alert-contrast alert-success alert-dismissible">
                <div class="icon"><span class="mdi mdi-check"></span></div>
                <div class="message">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <span aria-hidden="true" class="mdi mdi-close"></span>
                    </button>
                    <strong>Success!</strong> Settings has been updated.
                </div>
            </div>
        <?php endif; ?>

        <div class="panel panel-default">
            <div class="panel-heading panel-heading-divider">
                <?= Html::decode($this->title); ?>
                <span class="panel-subtitle">Default bootstrap modal component</span>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>

                <p class="lead">General</p>
                <?= $form->field($model, 'admin_email')->textInput(); ?>

                <p class="lead">Backups</p>
                <?= $form->field($model, 'backups_dir')->textInput(); ?>
                <?= $form->field($model, 'backups_max_count_copy')->textInput(); ?>
                <?= $form->field($model, 'remove_backups_after_days')->textInput(); ?>

                <p class="lead">Others</p>
                <?= $form->field($model, 'show_elements_on_page')->textInput(); ?>
                <?= $form->field($model, 'remove_logs_after_days')->textInput(); ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-space btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
