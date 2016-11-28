<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\RestorePassword */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Restore Password';
?>
<div class="splash-container forgot-password">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
        <div class="panel-heading">
            <a href="<?= Yii::$app->homeUrl ?>">
                <?= Html::img('/img/logo-xx.png', ['class' => 'logo-img', 'width' => 102, 'heigth' => 27]); ?>
            </a>
            <span class="splash-description"><?= Html::encode($this->title) ?></span>
        </div>
        <div class="panel-body">
            <?php if (Yii::$app->session->hasFlash('successRestorePassword')): ?>
                <div role="alert" class="alert alert-contrast alert-primary alert-dismissible">
                    <div class="icon"><span class="mdi mdi-info-outline"></span></div>
                    <div class="message">On your email has been sent an email with a link to reset your password.</div>
                </div>
            <?php else: ?>
                <?php $form = ActiveForm::begin(); ?>
                <p class="splash-title">Don't worry, we'll send you an email to reset your password.</p>

                <div class="xs-pt-20">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Your Email'])->label(false) ?>
                </div>

                <div class="form-group xs-pt-5">
                    <?= Html::submitButton('Restore Password', ['class' => 'btn btn-block btn-primary btn-xl']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="splash-footer">&copy; <?= Yii::$app->name ?></div>
</div>
