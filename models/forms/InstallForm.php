<?php

namespace app\models\forms;

use app\models\Users;
use yii\base\Model;

class InstallForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'string', 'min' => 6],
            ['email', 'email']
        ];
    }

    public function install()
    {
        if (!$this->validate()) {
            return false;
        }

        // @todo: install db schema

        // create admin
        $user = new Users([
            'email' => $this->email,
            'password' => \Yii::$app->security->generatePasswordHash($this->password),
            'auth_key' => \Yii::$app->security->generateRandomString(15),
            'has_create' => true,
            'has_delete' => true,
            'has_update' => true,
            'has_edit' => true,
        ]);

        return $user->save() ? true : false;
    }

}