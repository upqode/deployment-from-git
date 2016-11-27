<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="splash-container">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading">
            <?= Html::img('/img/logo-xx.png', ['class' => 'logo-img', 'width' => 102, 'heigth' => 27]); ?>
            <span class="splash-description">Login in system</span>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

            <div class="form-group row login-tools">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"col-xs-6 login-remember\"><div class=\"be-checkbox\">{input}\n{label}</div></div>\n",
                ]) ?>

                <div class="col-xs-6 login-forgot-password"><?= Html::a('Forgot password?', 'restore'); ?></div>
            </div>

            <div class="form-group login-submit">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-xl']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="splash-footer">&copy; 2016 Deployment from Git</div>
</div>
