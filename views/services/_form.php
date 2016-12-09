<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\ServiceForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'type')->radioList([$model::TYPE_GITHUB => 'GitHub', $model::TYPE_BITBUCKET => 'BitBucket']) ?>

<?= $form->field($model, 'username')->textInput(['placeholder' => 'Username']) ?>

<?= $form->field($model, 'access_token')->textInput(['placeholder' => 'Access token']) ?>

<?= $form->field($model, 'is_active')->checkbox([
    'template' => '<div class="be-checkbox has-success">{input} {label}</div>',
]); ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-space btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
