<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Backups';
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">Responsive Table
                <div class="tools"><span class="icon mdi mdi-download"></span><span class="icon mdi mdi-more-vert"></span></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive noSwipe">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th style="width:5%;">
                                <div class="be-checkbox be-checkbox-sm">
                                    <input id="check1" type="checkbox">
                                    <label for="check1"></label>
                                </div>
                            </th>
                            <th style="width:20%;">User</th>
                            <th style="width:17%;">Last Commit</th>
                            <th style="width:15%;">Milestone</th>
                            <th style="width:10%;">Branch</th>
                            <th style="width:10%;">Date</th>
                            <th style="width:10%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="be-checkbox be-checkbox-sm">
                                    <input id="check2" type="checkbox">
                                    <label for="check2"></label>
                                </div>
                            </td>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Penelope Thornton</span><span class="cell-detail-description">Developer</span></td>
                            <td class="cell-detail"> <span>Initial commit</span><span class="cell-detail-description">Bootstrap Admin</span></td>
                            <td class="milestone"><span class="completed">8 / 15</span><span class="version">v1.2.0</span>
                                <div class="progress">
                                    <div style="width: 45%" class="progress-bar progress-bar-primary"></div>
                                </div>
                            </td>
                            <td class="cell-detail"><span>master</span><span class="cell-detail-description">63e8ec3</span></td>
                            <td class="cell-detail"><span>May 6, 2016</span><span class="cell-detail-description">8:30</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Open <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="online">
                            <td>
                                <div class="be-checkbox be-checkbox-sm">
                                    <input id="check3" type="checkbox">
                                    <label for="check3"></label>
                                </div>
                            </td>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Benji Harper</span><span class="cell-detail-description">Designer</span></td>
                            <td class="cell-detail"> <span>Main structure markup</span><span class="cell-detail-description">CLI Connector</span></td>
                            <td class="milestone"><span class="completed">22 / 30</span><span class="version">v1.1.5</span>
                                <div class="progress">
                                    <div style="width: 75%" class="progress-bar progress-bar-primary"></div>
                                </div>
                            </td>
                            <td class="cell-detail"><span>develop</span><span class="cell-detail-description">4cc1bc2</span></td>
                            <td class="cell-detail"><span>April 22, 2016</span><span class="cell-detail-description">14:45</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Open <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="be-checkbox be-checkbox-sm">
                                    <input id="check4" type="checkbox">
                                    <label for="check4"></label>
                                </div>
                            </td>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Justine Myranda</span><span class="cell-detail-description">Designer</span></td>
                            <td class="cell-detail"> <span>Left sidebar adjusments</span><span class="cell-detail-description">Back-end Manager</span></td>
                            <td class="milestone"><span class="completed">10 / 30</span><span class="version">v1.1.3</span>
                                <div class="progress">
                                    <div style="width: 33%" class="progress-bar progress-bar-primary"></div>
                                </div>
                            </td>
                            <td class="cell-detail"><span>develop</span><span class="cell-detail-description">5477993</span></td>
                            <td class="cell-detail"><span>April 15, 2016</span><span class="cell-detail-description">10:00</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Open <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="be-checkbox be-checkbox-sm">
                                    <input id="check5" type="checkbox">
                                    <label for="check5"></label>
                                </div>
                            </td>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Sherwood Clifford</span><span class="cell-detail-description">Developer</span></td>
                            <td class="cell-detail"> <span>Topbar dropdown style</span><span class="cell-detail-description">Bootstrap Admin</span></td>
                            <td class="milestone"><span class="completed">25 / 40</span><span class="version">v1.0.4</span>
                                <div class="progress">
                                    <div style="width: 55%" class="progress-bar progress-bar-primary"></div>
                                </div>
                            </td>
                            <td class="cell-detail"><span>master</span><span class="cell-detail-description">8cb98ec</span></td>
                            <td class="cell-detail"><span>April 8, 2016</span><span class="cell-detail-description">17:24</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Open <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="online">
                            <td>
                                <div class="be-checkbox be-checkbox-sm">
                                    <input id="check6" type="checkbox">
                                    <label for="check6"></label>
                                </div>
                            </td>
                            <td class="user-avatar cell-detail user-info"><?= Html::img('/img/avatar.png'); ?><span>Kristopher Donny</span><span class="cell-detail-description">Designer</span></td>
                            <td class="cell-detail"> <span>Right sidebar adjusments</span><span class="cell-detail-description">CLI Connector</span></td>
                            <td class="milestone"><span class="completed">38 / 40</span><span class="version">v1.0.1</span>
                                <div class="progress">
                                    <div style="width: 98%" class="progress-bar progress-bar-primary"></div>
                                </div>
                            </td>
                            <td class="cell-detail"><span>master</span><span class="cell-detail-description">65bc2da</span></td>
                            <td class="cell-detail"><span>Mars 18, 2016</span><span class="cell-detail-description">13:02</span></td>
                            <td class="text-right">
                                <div class="btn-group btn-hspace">
                                    <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Open <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated lin</a></li>
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
