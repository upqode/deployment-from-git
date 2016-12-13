<?php

/* @var $this yii\web\View */
/* @var $model \app\models\forms\RepositoryForm */
/* @var $folder_list array */

use yii\bootstrap\Html;

$this->title = 'Settings Repository';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading panel-heading-divider">
                <?= Html::encode($this->title); ?>
                <span class="panel-subtitle"><?= $model->name ?></span>
            </div>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'folder_list' => $folder_list,
                ]); ?>
            </div>
        </div>
    </div>
</div>
