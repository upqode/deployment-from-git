<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\InstallForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Install';
?>
<div class="splash-container sign-up">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading">
            <?= Html::img('/img/logo-xx.png', ['class' => 'logo-img', 'width' => 102, 'heigth' => 27]); ?>
            <span class="splash-description">Install system</span>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
                <span class="splash-title xs-pb-20">Setting database</span>
                <div class="form-group">
                    <input type="text" name="nick" placeholder="Сервер базы данных" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="email" placeholder="Имя базы данных" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="email" placeholder="Имя пользователя" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="email" placeholder="Пароль" autocomplete="off" class="form-control">
                </div>

            <span class="splash-title xs-pb-20 xs-pt-20">Creating admin site</span>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

            <div class="form-group row signup-password">
                <div class="col-xs-6">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Password repeat'])->label(false) ?>
                </div>
            </div>

            <div class="form-group xs-pt-10">
                <?= Html::submitButton('Install', ['class' => 'btn btn-block btn-primary btn-xl']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="splash-footer">&copy; 2016 Deployment from Git</div>
</div>
