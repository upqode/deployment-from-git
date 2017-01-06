<?php

namespace app\models\forms;

use app\models\Settings;
use app\models\Users;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class RestorePassword extends Model
{
    const SCENARIO_RESTORE = 'restore';
    const SCENARIO_RESET = 'reset';

    public $email;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_RESTORE] = ['email'];
        $scenarios[self::SCENARIO_RESET] = ['password', 'password_repeat'];

        return $scenarios;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password', 'compare'],
            ['email', 'email'],
        ];
    }

    /**
     * Send reset link on user email
     *
     * @return bool
     */
    public function restore()
    {
        $user = Users::findByEmail($this->email);

        if (!$this->validate() || !$user) {
            return false;
        }

        $admin_email = Settings::getSettingValue(Settings::SETTING_ADMIN_EMAIL);
        $key = Yii::$app->security->generateRandomString(15);

        $user->reset_key = $key;
        $user->save();

        Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([$admin_email => Yii::$app->name])
            ->setSubject('Reset password')
            ->setHtmlBody('Please open <a href="'. Url::toRoute(['/site/reset-password', 'email' => urlencode($this->email), 'key' => $key], true) .'">this link</a>')
            ->send();

        return true;
    }

    /**
     * Change user password
     *
     * @param string $email
     * @return bool
     */
    public function reset($email)
    {
        if (!$this->validate()) {
            return false;
        }

        $user = Users::findByEmail($email);

        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->reset_key = null;
        return $user->save();
    }

}