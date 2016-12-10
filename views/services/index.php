<?php

/* @var $this yii\web\View */
/* @var $pages \yii\data\Pagination */
/* @var $service \app\models\Services */
/* @var $services array */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Services';
?>
<?php if (Yii::$app->session->hasFlash('serviceOperation')): ?>
    <div class="row">
        <div class="col-sm-12">
            <?php $flash = Yii::$app->session->getFlash('serviceOperation'); ?>
            <div role="alert" class="alert alert-contrast <?= $flash['type'] ?> alert-dismissible">
                <div class="icon"><span class="<?= $flash['icon'] ?>"></span></div>
                <div class="message">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <span aria-hidden="true" class="mdi mdi-close"></span>
                    </button>
                    <strong><?= $flash['title'] ?></strong> <?= $flash['message'] ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="user-profile">
    <div class="row sm-mt-50">
        <?php if ($services): ?>
            <?php foreach ($services as $service): ?>
                <div class="col-md-4">
                    <div class="user-display">
                        <div class="user-display-bottom">
                            <div class="user-display-avatar">
                                <?= Html::img($service->getServiceImg()); ?>
                            </div>
                            <div class="user-display-info">
                                <div class="name"><?= $service->username ?></div>
                                <div class="nick">
                                    <span class="mdi mdi-dns"></span> <?= $service->getServiceName(); ?>
                                </div>
                            </div>
                            <div class="row user-display-details">
                                <div class="col-xs-4">
                                    <div class="title">Created</div>
                                    <div class="counter"><?= Yii::$app->formatter->asDate($service->created_date) ?></div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="title">Repositories</div>
                                    <div class="counter"><?= $service->getRepositoryCount() ?></div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="title">Status</div>
                                    <div class="btn-group btn-group-sm btn-hspace">
                                        <button type="button" data-toggle="dropdown" class="btn btn-rounded dropdown-toggle <?= ($service->is_active) ? 'btn-success' : 'btn-danger'; ?>" aria-expanded="false">
                                            <?= ($service->is_active) ? 'Active' : 'Disabled'; ?> <span class="icon-dropdown mdi mdi-chevron-down"></span>
                                        </button>

                                        <ul role="menu" class="dropdown-menu">
                                            <?php if ($service->is_active): ?>
                                                <li>
                                                    <?= Html::a('Deactivate', ['deactivate', 'id' => $service->id], [
                                                        'data' => [
                                                            'method' => 'POST',
                                                            'confirm' => 'Are you sure you want to deactivate this service?',
                                                        ],
                                                    ]) ?>
                                                </li>
                                            <?php else: ?>
                                                <li><?= Html::a('Activate', ['activate', 'id' => $service->id]); ?></li>
                                            <?php endif; ?>
                                            <li><?= Html::a('Test connection', ['test', 'id' => $service->id]); ?></li>
                                            <li><?= Html::a('Settings', ['settings', 'id' => $service->id]); ?></li>
                                            <li>
                                                <?= Html::a('Delete', ['delete', 'id' => $service->id], [
                                                    'data' => [
                                                        'method' => 'POST',
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                    ],
                                                ]); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>
