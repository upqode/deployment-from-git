<?php

namespace app\models\forms;

use app\models\Users;
use Yii;
use yii\base\Model;

class UserForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_USER_PASS = 'user_pass';
    const SCENARIO_USER_INFO = 'user_info';

    public $name;
    public $email;
    public $password;
    public $old_password;
    public $repeat_password;
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
        $scenarios[self::SCENARIO_USER_PASS] = ['password', 'old_password', 'repeat_password'];
        $scenarios[self::SCENARIO_USER_INFO] = ['name'];

        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'old_password', 'repeat_password'], 'required'],
            [['is_admin', 'has_edit', 'has_create', 'has_update', 'has_delete'], 'boolean'],
            [['password', 'old_password', 'repeat_password'], 'string', 'min' => 6],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['name', 'string'],
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