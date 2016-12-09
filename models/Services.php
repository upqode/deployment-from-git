<?php

namespace app\models;

use app\models\forms\ServiceForm;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "services".
 *
 * @property integer $id
 * @property integer $type
 * @property string  $username
 * @property string  $access_token
 * @property integer $created_date
 * @property boolean $is_active
 */
class Services extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'username', 'access_token', 'created_date'], 'required'],
            [['type', 'created_date'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['access_token'], 'string', 'max' => 100],
            ['is_active', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'username' => 'Username',
            'access_token' => 'Access Token',
            'created_date' => 'Created Date',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Get service image
     *
     * @return string
     */
    public function getServiceImg()
    {
        return ($this->type === ServiceForm::TYPE_GITHUB) ? '/img/github-big.png' : '/img/bitbucket-big.png';
    }

    /**
     * Get service name
     *
     * @return string
     */
    public function getServiceName()
    {
        return ($this->type === ServiceForm::TYPE_GITHUB) ? 'GitHub' : 'BitBucket';
    }

    public function getRepositoryCount()
    {
        return random_int(1, 100); // @todo: change!
    }

    /**
     * Activated/Deactivated service
     *
     * @param integer $id
     * @param boolean $is_active
     */
    public static function setServiceStatus($id, $is_active)
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;
        $service = Services::findOne(intval($id));

        if ($service && $user->is_admin) {
            $service->is_active = $is_active;
            $service->update();

            Yii::$app->session->setFlash('serviceOperation', [
                'type' => 'alert-success',
                'icon' => 'mdi mdi-check',
                'title' => 'Success!',
                'message' => ($is_active) ? 'Service activated!' : 'Service deactivated!',
            ]);
        } else {
            Yii::$app->session->setFlash('serviceOperation', [
                'type' => 'alert-danger',
                'icon' => 'mdi mdi-close-circle-o',
                'title' => 'Danger!',
                'message' => 'У вас недостаточно прав для выполнения данного действия!',
            ]);
        }
    }

}
