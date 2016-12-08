<?php

/* @var $this yii\web\View */
/* @var $model_settings \app\models\forms\UserForm */
/* @var $model_password \app\models\forms\UserForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'User Settings';
?>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-divider">
                <?= Html::encode($this->title); ?>
                <span class="panel-subtitle">This is the default bootstrap form layout</span>
            </div>
            <div class="panel-body">
                <?php $form_setting = ActiveForm::begin(); ?>

                <?= Html::hiddenInput('type', $model_settings::SCENARIO_USER_INFO) ?>

                <?= $form_setting->field($model_settings, 'name')->textInput(['placeholder' => 'Your Name']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Change', ['class' => 'btn btn-space btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-divider">
                Change Password
                <span class="panel-subtitle">Default bootstrap modal with a footer content</span>
            </div>
            <div class="panel-body">
                <?php $form_password = ActiveForm::begin(); ?>

                <?= Html::hiddenInput('type', $model_password::SCENARIO_USER_PASS) ?>

                <?= $form_password->field($model_password, 'old_password')->passwordInput(['placeholder' => 'Old Password']) ?>

                <?= $form_password->field($model_password, 'password')->passwordInput(['placeholder' => 'New Password']) ?>

                <?= $form_password->field($model_password, 'repeat_password')->passwordInput(['placeholder' => 'New Password Again']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Change', ['class' => 'btn btn-space btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
