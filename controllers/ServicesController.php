<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\forms\ServiceForm;
use Yii;
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

    public function actionIndex()
    {
        return $this->render('index');
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