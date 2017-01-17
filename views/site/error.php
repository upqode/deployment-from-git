<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$code = isset($exception->statusCode) ? $exception->statusCode : 400;
?>
<div class="error-container">
    <div class="error-number"><?= Html::encode($code) ?></div>
    <div class="error-description"><?= Html::encode($this->title) ?></div>
    <div class="error-goback-text"><?= nl2br(Html::encode($message)) ?></div>
    <div class="error-goback-button">
        <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-xl btn-primary">Let's go home</a>
    </div>
    <div class="footer">&copy; <?= date('Y') .' '. Yii::$app->name ?></div>
</div>
