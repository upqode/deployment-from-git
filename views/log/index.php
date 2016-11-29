<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Logs';
?>
<div class="row">
    <div class="col-md-12">
        <ul class="timeline">
            <li class="timeline-item">
                <div class="timeline-date"><span>September 16, 2016</span></div>
                <div class="timeline-content">
                    <div class="timeline-avatar"><?= Html::img('/img/avatar.png', ['class' => 'circle']); ?></div>
                    <div class="timeline-header">
                        <span class="timeline-time">4:34 PM</span><span class="timeline-autor">Penelope Thornton</span>
                        <span class="icon mdi mdi-more-vert"></span>
                        <p class="timeline-activity">Pellentesque imperdiet sit <a href="#">Amet nisl sed mattis</a>.</p>
                    </div>
                </div>
            </li>
            <li class="timeline-item timeline-item-detailed">
                <div class="timeline-date"><span>September 13, 2016</span></div>
                <div class="timeline-content">
                    <div class="timeline-avatar"><?= Html::img('/img/avatar.png', ['class' => 'circle']); ?></div>
                    <div class="timeline-header">
                        <span class="timeline-time">9:54 AM</span><span class="timeline-autor">Kristopher Donny  </span>
                        <p class="timeline-activity">Mauris condimentum est <a href="#">Viverra erat fermentum</a>.</p>
                        <div class="timeline-summary">
                            <p>Suspendisse ac libero sed mauris tempor vehicula porttitor non sapien. Aliquam viver... </p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="timeline-item timeline-item-detailed">
                <div class="timeline-date"><span>August 6, 2016</span></div>
                <div class="timeline-content">
                    <div class="timeline-avatar"><?= Html::img('/img/avatar.png', ['class' => 'circle']); ?></div>
                    <div class="timeline-header">
                        <span class="timeline-time">7:15 PM</span><span class="timeline-autor">Benji Harper </span>
                        <p class="timeline-activity">Mauris condimentum est <a href="#">Vestibulum justo neque</a>.</p>
                        <div class="timeline-summary">
                            <p>Quisque condimentum enim nec porttitor egestas. Morbi fermentum in ante volutpat... </p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="timeline-item">
                <div class="timeline-date"><span>August 4, 2016</span></div>
                <div class="timeline-content">
                    <div class="timeline-avatar"><?= Html::img('/img/avatar.png', ['class' => 'circle']); ?></div>
                    <div class="timeline-header">
                        <span class="timeline-time">12:02 PM</span><span class="timeline-autor">Justine Myranda </span>
                        <p class="timeline-activity">Pellentesque imperdiet sit <a href="#">Amet nisl sed mattiss</a>.</p>
                    </div>
                </div>
            </li>
            <li class="timeline-item timeline-loadmore"><a href="#" class="load-more-btn">Load more</a></li>
        </ul>
    </div>
</div>
