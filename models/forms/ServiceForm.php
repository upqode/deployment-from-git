<?php

namespace app\models\forms;

use app\models\Logs;
use app\models\Services;
use Yii;
use yii\base\Model;

class ServiceForm extends Model
{
    const TYPE_GITHUB = 1;
    const TYPE_BITBUCKET = 2;

    public $type;
    public $username;
    public $access_token;
    public $is_active;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['type', 'username', 'access_token', 'is_active'], 'required'],
            ['type', 'in', 'range' => [$this::TYPE_GITHUB, $this::TYPE_BITBUCKET]],
            [['username', 'access_token'], 'string'],
            ['is_active', 'boolean'],
            ['type', 'integer'],
        ];
    }

    /**
     * Add Service
     *
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $service = new Services([
            'type' => $this->type,
            'username' => $this->username,
            'access_token' => $this->access_token,
            'created_date' => Yii::$app->formatter->asTimestamp('now'),
            'is_active' => $this->is_active,
        ]);

        Logs::setLog(101, [':service_name' => $service->username, ':service_type' => $service->getServiceName()]);

        return $service->save();
    }

}