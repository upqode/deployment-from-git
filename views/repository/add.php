<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\RepositoryForm */
/* @var $service_list array */
/* @var $folder_list array */

use yii\bootstrap\Html;

$this->title = 'Register Repository';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading panel-heading-divider">
                <?= Html::encode($this->title); ?>
                <span class="panel-subtitle">This is the default bootstrap form layout</span>
            </div>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'folder_list' => $folder_list,
                    'service_list' => $service_list,
                ]); ?>
            </div>
        </div>
    </div>
</div>
