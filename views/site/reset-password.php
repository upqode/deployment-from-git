<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\RestorePassword */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset Password';
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
            <?php $form = ActiveForm::begin(); ?>
            <p class="splash-title">Please enter a new password, and this time try not to forget it =)</p>

            <div class="xs-pt-20">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'New password'])->label(false) ?>

                <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'New password repeat'])->label(false) ?>
            </div>

            <div class="form-group xs-pt-5">
                <?= Html::submitButton('Reset Password', ['class' => 'btn btn-block btn-primary btn-xl']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="splash-footer">&copy; <?= Yii::$app->name ?></div>
</div>
