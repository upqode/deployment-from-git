<?php

namespace app\models\forms;

use app\models\Users;
use Yii;
use yii\base\Model;

class UserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $email;
    public $password;
    public $is_admin;
    public $has_create;
    public $has_delete;
    public $has_update;
    public $has_edit;

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['email', 'password', 'is_admin', 'has_edit', 'has_create', 'has_update', 'has_delete'];
        $scenarios[self::SCENARIO_UPDATE] = ['is_admin', 'has_edit', 'has_create', 'has_update', 'has_delete'];

        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['is_admin', 'has_edit', 'has_create', 'has_update', 'has_delete'], 'boolean'],
            ['password', 'string', 'min' => 6],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => Users::className()],
        ];
    }

    /**
     * Save user
     *
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new Users();
        $user->attributes = $this->attributes;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString(15);
        $user->email = $this->email;

        return $user->save();
    }

}