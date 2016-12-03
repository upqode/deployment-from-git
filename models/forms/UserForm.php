<?php

namespace app\models\forms;

use app\models\Users;
use Yii;
use yii\base\Model;

class UserForm extends Model
{

    public $email;
    public $password;
    public $has_create;
    public $has_delete;
    public $has_update;
    public $has_edit;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['has_edit', 'has_create', 'has_update', 'has_delete'], 'boolean'],
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

        return $user->save();
    }

}