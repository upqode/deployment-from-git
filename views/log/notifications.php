<?php
/** @var array $logs */
/** @var \app\models\Logs $log */

use yii\bootstrap\Html;

?>
<?php if ($logs): ?>
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
            <span class="icon mdi mdi-notifications"></span>
        </a>
        <ul class="dropdown-menu be-notifications">
            <li>
                <div class="title">Notifications</div>
                <div class="list">
                    <div class="be-scroller">
                        <div class="content">
                            <ul>
                                <?php foreach ($logs as $log): ?>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><?= Html::img('/img/avatar.png'); ?></div>
                                            <div class="notification-info">
                                                <div class="text"><?= Html::decode($log->action); ?></div>
                                                <span class="date"><?= Yii::$app->formatter->asDatetime($log->time); ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer"><?= Html::a('View all notifications', ['/log']); ?></div>
            </li>
        </ul>
    </li>
<?php endif; ?>
