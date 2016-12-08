<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\UserForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>

<?php $form = ActiveForm::begin(); ?>

<?php if ($model->scenario == $model::SCENARIO_CREATE): ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

    <?= $form->field($model, 'repeat_password')->passwordInput(['placeholder' => 'Password again']) ?>

<?php endif; ?>

<div class="form-group">
    <label>Repository Permissions</label>

    <?= $form->field($model, 'has_create')->checkbox([
        'template' => '<div class="be-checkbox">{input} {label}</div>',
    ]) ?>

    <?= $form->field($model, 'has_edit')->checkbox([
        'template' => '<div class="be-checkbox">{input} {label}</div>',
    ]) ?>

    <?= $form->field($model, 'has_delete')->checkbox([
        'template' => '<div class="be-checkbox">{input} {label}</div>',
    ]) ?>

    <?= $form->field($model, 'has_update')->checkbox([
        'template' => '<div class="be-checkbox">{input} {label}</div>',
    ]) ?>
</div>

<div class="form-group">
    <label>User Permissions</label>

    <?= $form->field($model, 'is_admin')->checkbox([
        'template' => '<div class="be-checkbox">{input} {label}</div>',
    ]) ?>
</div>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-space btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
