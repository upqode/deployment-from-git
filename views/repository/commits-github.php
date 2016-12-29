<?php

/* @var $this yii\web\View */
/* @var $repository \app\models\Repositories */
/* @var $commits array */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Repository Commits';
$this->registerCssFile('/library/sweetalert/sweetalert.css');
$this->registerJsFile('/library/sweetalert/sweetalert.min.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('/js/repository.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary panel-table">
            <div class="panel-heading panel-heading-divider">
                <?= $repository->name ?>
                <span class="panel-subtitle"><?= Html::encode($this->title); ?></span>
                <?= Html::hiddenInput('repository_id', $repository->id, ['id' => 'repository-id']); ?>
            </div>
            <div class="panel-body">
                <div class="table-responsived noSwipe">
                    <?php if ($commits): ?>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width: 25%;">User</th>
                                <th style="width: 55%;">Commit</th>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 10%;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($commits as $commit): ?>
                                <tr class="<?= ($commit['sha'] == ArrayHelper::getValue($repository->commit, 'sha')) ? 'online' : ''; ?>">
                                    <td class="user-avatar cell-detail user-info">
                                        <?= Html::img($commit['author']['avatar_url']); ?>
                                        <span><?= Html::encode($commit['author']['login']); ?></span>
                                        <span class="cell-detail-description">
                                            <?= Html::encode($commit['commit']['author']['email']); ?>
                                        </span>
                                    </td>
                                    <td class="cell-detail">
                                        <span><?= Html::encode($commit['commit']['message']); ?></span>
                                        <span class="cell-detail-description">
                                            <?= Html::encode($commit['sha']); ?>
                                        </span>
                                    </td>
                                    <td class="cell-detail">
                                        <span>
                                            <?= Yii::$app->formatter->asDate(Html::encode($commit['commit']['author']['date'])); ?>
                                        </span>
                                        <span class="cell-detail-description">
                                            <?= Yii::$app->formatter->asTime(Html::encode($commit['commit']['author']['date'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-hspace">
                                            <a href="#" class="btn btn-space btn-default install-commit-btn" data-commit="<?= $commit['sha'] ?>">
                                                <i class="icon icon-left mdi mdi-download"></i> Install this version
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <h1 class="text-center">Commits not found!</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
