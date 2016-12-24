<?php

/* @var $this yii\web\View */
/* @var $repository \app\models\Repositories */
/* @var $branches array */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Repository Branches';
$this->registerCssFile('/library/sweetalert/sweetalert.css');
$this->registerJsFile('/library/sweetalert/sweetalert.min.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('/js/add-repository.js', ['depends' => ['yii\web\JqueryAsset']]);
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
                    <?php if ($branches): ?>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Branch</th>
                                <th>Last Commit</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($branches as $branch): ?>
                                <tr class="<?= ($branch['commit']['sha'] == ArrayHelper::getValue($repository->commit, 'sha')) ? 'online' : ''; ?>">
                                    <td class="cell-detail">
                                        <span><?= Html::encode($branch['name']); ?></span>
                                    </td>
                                    <td class="cell-detail">
                                        <span>
                                            <?= Html::encode($branch['commit']['sha']); ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-hspace">
                                            <a href="#" class="btn btn-space btn-default install-commit-btn" data-commit="<?= $branch['commit']['sha'] ?>" data-force="true">
                                                <i class="icon icon-left mdi mdi-download"></i> Install this version
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
