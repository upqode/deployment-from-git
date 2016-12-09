<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\ServiceForm */

use yii\bootstrap\Html;

$this->title = 'Add Service';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading panel-heading-divider">
                <?= Html::encode($this->title); ?>
                <span class="panel-subtitle">This is the default bootstrap form layout</span>
            </div>
            <div class="panel-body">
                <?= $this->render('_form', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>
