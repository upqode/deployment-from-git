<?php

namespace app\models\forms;

use app\components\Install;
use app\models\Users;
use Yii;
use yii\base\Model;

class InstallForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password', 'compare'],
            ['email', 'email'],
        ];
    }

    public function install()
    {
        if (!$this->validate()) {
            return false;
        }

        Install::installDbScheme();

        // create admin
        $user = new Users([
            'email' => $this->email,
            'password' => Yii::$app->security->generatePasswordHash($this->password),
            'auth_key' => Yii::$app->security->generateRandomString(15),
            'is_admin' => true,
            'has_create' => true,
            'has_delete' => true,
            'has_update' => true,
            'has_edit' => true,
        ]);

        return $user->save();
    }

}