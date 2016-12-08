<?php

/* @var $this yii\web\View */
/* @var $user \app\models\Users */
/* @var $users \app\models\Users */
/* @var $pages \yii\data\Pagination */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Users';
?>
<div class="row">
    <div class="col-sm-12">
        <?php if (Yii::$app->session->hasFlash('userOperation')): ?>
            <?php $flash = Yii::$app->session->getFlash('userOperation'); ?>
            <div role="alert" class="alert alert-contrast <?= $flash['type'] ?> alert-dismissible">
                <div class="icon"><span class="<?= $flash['icon'] ?>"></span></div>
                <div class="message">
                    <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                        <span aria-hidden="true" class="mdi mdi-close"></span>
                    </button>
                    <strong><?= $flash['title'] ?></strong> <?= $flash['message'] ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="panel panel-default panel-table">
            <div class="panel-heading">User lists
                <div class="tools">
                    <a href="<?= Url::toRoute(['create']); ?>"><span class="icon mdi mdi-account-add"></span></a>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($users): ?>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width:35%;">User</th>
                            <th style="width:40%;">Latest activity</th>
                            <th style="width:20%;">Permissions</th>
                            <th style="width:5%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="online">
                                <td class="user-avatar cell-detail user-info">
                                    <?= Html::img('/img/avatar.png'); ?>
                                    <span><?= $user->getName(); ?></span>
                                    <span class="cell-detail-description"><?= $user->email ?></span>
                                </td>
                                <td class="cell-detail">
                                    <span>Action</span>
                                    <span class="cell-detail-description">Repository</span>
                                </td>
                                <td class="cell-detail">
                                    <span class="cell-detail-description"><?= $user->getPermissionsList(); ?></span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-hspace">
                                        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Action <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                        <ul role="menu" class="dropdown-menu pull-right">
                                            <li><a href="#">Latest activity</a></li>
                                            <li><?= Html::a('Modify', ['update', 'id' => $user->id]); ?></li>
                                            <li>
                                                <?= Html::a('Delete', ['delete', 'id' => $user->id], [
                                                    'data' => [
                                                        'method' => 'POST',
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                    ],
                                                ]); ?>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?= LinkPager::widget(['pagination' => $pages]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
