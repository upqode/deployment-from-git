<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Users';
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">Список пользователей
                <div class="tools"><span class="icon mdi mdi-account-add"></span></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive noSwipe">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width:20%;">Пользователь</th>
                            <th style="width:17%;">Последнее действие</th>
                            <th style="width:15%;">Права доступа</th>
                            <th style="width:10%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="user-avatar cell-detail user-info">
                                <?= Html::img('/img/avatar.png'); ?>
                                <span>Penelope Thornton</span>
                                <span class="cell-detail-description">Developer</span>
                            </td>
                            <td class="cell-detail">
                                <span>Initial commit</span>
                                <span class="cell-detail-description">Bootstrap Admin</span>
                            </td>
                            <td class="cell-detail">
                                <span>master</span>
                                <span class="cell-detail-description">63e8ec3</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Управление <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Последнее действия</a></li>
                                        <li><a href="#">Редактировать</a></li>
                                        <li><a href="#">Удалить</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="online">
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Benji Harper</span><span class="cell-detail-description">Designer</span></td>
                            <td class="cell-detail"> <span>Main structure markup</span><span class="cell-detail-description">CLI Connector</span></td>
                            <td class="cell-detail"><span>develop</span><span class="cell-detail-description">4cc1bc2</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Управление <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Последнее действия</a></li>
                                        <li><a href="#">Редактировать</a></li>
                                        <li><a href="#">Удалить</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Justine Myranda</span><span class="cell-detail-description">Designer</span></td>
                            <td class="cell-detail"> <span>Left sidebar adjusments</span><span class="cell-detail-description">Back-end Manager</span></td>
                            <td class="cell-detail"><span>develop</span><span class="cell-detail-description">5477993</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Управление <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Последнее действия</a></li>
                                        <li><a href="#">Редактировать</a></li>
                                        <li><a href="#">Удалить</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Sherwood Clifford</span><span class="cell-detail-description">Developer</span></td>
                            <td class="cell-detail"> <span>Topbar dropdown style</span><span class="cell-detail-description">Bootstrap Admin</span></td>
                            <td class="cell-detail"><span>master</span><span class="cell-detail-description">8cb98ec</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Управление <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Последнее действия</a></li>
                                        <li><a href="#">Редактировать</a></li>
                                        <li><a href="#">Удалить</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="online">
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Kristopher Donny</span><span class="cell-detail-description">Designer</span></td>
                            <td class="cell-detail"> <span>Right sidebar adjusments</span><span class="cell-detail-description">CLI Connector</span></td>
                            <td class="cell-detail"><span>master</span><span class="cell-detail-description">65bc2da</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Управление <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Последнее действия</a></li>
                                        <li><a href="#">Редактировать</a></li>
                                        <li><a href="#">Удалить</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
