<?php

/* @var $this yii\web\View */
/* @var $pages \yii\data\Pagination */
/* @var $log \app\models\Logs */
/* @var $logs array */

use yii\helpers\Html;

$this->title = 'Logs';
?>
<div class="row">
    <div class="col-md-12">
        <?php if ($logs): ?>
            <ul class="timeline">
                <?php foreach ($logs as $log): ?>
                    <li class="timeline-item">
                        <div class="timeline-date"><span><?= Yii::$app->formatter->asDate($log->time); ?></span></div>
                        <div class="timeline-content">
                            <div class="timeline-avatar"><?= Html::img('/img/avatar.png', ['class' => 'circle']); ?></div>
                            <div class="timeline-header">
                                <span class="timeline-time"><?= Yii::$app->formatter->asTime($log->time); ?></span>
                                <p class="timeline-activity"><?= Html::decode($log->action); ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <li class="timeline-item timeline-loadmore"><a href="#" class="load-more-btn">Load more</a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
