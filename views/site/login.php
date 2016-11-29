<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login in system';
?>
<div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading">
            <a href="<?= Yii::$app->homeUrl ?>">
                <?= Html::img('/img/logo-xx.png', ['class' => 'logo-img', 'width' => 102, 'heigth' => 27]); ?>
            </a>
            <span class="splash-description"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="panel-body">
            <?php if (Yii::$app->session->hasFlash('successResetPassword')): ?>
                <div role="alert" class="alert alert-contrast alert-success alert-dismissible">
                    <div class="icon"><span class="mdi mdi-check"></span></div>
                    <div class="message">
                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
                        Your password has been successfully changed! You can login with the new password.
                    </div>
                </div>
            <?php endif; ?>

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

            <div class="form-group row login-tools">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"col-xs-6 login-remember\"><div class=\"be-checkbox\">{input}\n{label}</div></div>\n",
                ]) ?>

                <div class="col-xs-6 login-forgot-password"><?= Html::a('Forgot password?', 'restore-password'); ?></div>
            </div>

            <div class="form-group login-submit">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-xl']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="splash-footer">&copy; <?= Yii::$app->name ?></div>
</div>
