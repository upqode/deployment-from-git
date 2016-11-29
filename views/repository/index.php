<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Repositories';
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="tools"><span class="icon mdi mdi-download"></span><span class="icon mdi mdi-more-vert"></span></div>
                <div class="title">Latest Commits</div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width:37%;">User</th>
                        <th style="width:36%;">Commit</th>
                        <th>Date</th>
                        <th class="actions"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Penelope Thornton</td>
                        <td>Topbar dropdown style</td>
                        <td>Aug 16, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Benji Harper</td>
                        <td>Left sidebar adjusments</td>
                        <td>Jul 15, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Justine Myranda</td>
                        <td>Main structure markup</td>
                        <td>Jul 28, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td class="user-avatar"><?= Html::img('/img/avatar.png'); ?> Sherwood Clifford</td>
                        <td>Initial commit</td>
                        <td>Jun 30, 2016</td>
                        <td class="actions"><a href="#" class="icon"><i class="mdi mdi-github-alt"></i></a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
