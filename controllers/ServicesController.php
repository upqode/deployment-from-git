<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\ServiceForm;
use app\models\Services;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;

class ServicesController extends BaseController
{

    public $layout = BaseController::LAYOUT_AUTHORIZED;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
        ];
    }

    /**
     * Service list
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Services::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 15]);
        $services = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', [
            'pages' => $pages,
            'services' => $services,
        ]);
    }

    /**
     * Add new service
     *
     * @param integer $type
     * @return string|\yii\web\Response
     */
    public function actionAdd($type)
    {
        $model = new ServiceForm();

        if ($type != $model::TYPE_GITHUB && $type != $model::TYPE_BITBUCKET) {
            return $this->redirect(['index']);
        }

        $model->type = $type;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('serviceOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => 'Service added!',
            ]);

            return $this->redirect(['index']);
        }

        return $this->render('add', ['model' => $model]);
    }

}