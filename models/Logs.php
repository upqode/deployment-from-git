<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $action
 * @property integer $time
 */
class Logs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action', 'time'], 'required'],
            [['user_id', 'time'], 'integer'],
            [['action'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'time' => 'Time',
        ];
    }

    /**
     * @param int $msd_id
     * @param array $msg_params
     * @return bool|string
     */
    public static function getMessageText($msd_id, $msg_params = [])
    {
        $messages = [
            // services
            101 => 'User <b>:user</b> created <b>:service_name (:service_type)</b> service!',
            102 => 'User <b>:user</b> modify <b>:service_name (:service_type)</b> service setting!',
            103 => 'User <b>:user</b> activated <b>:service_name (:service_type)</b> service!',
            104 => 'User <b>:user</b> deactivated <b>:service_name (:service_type)</b> service!',
            105 => 'User <b>:user</b> deleted <b>:service_name (:service_type)</b> service!',
            // users
            201 => 'User <b>:user</b> created <b>:profile</b> profile!',
            202 => 'User <b>:user</b> modify <b>:profile</b> profile permissions!',
            203 => 'User <b>:user</b> deleted <b>:profile</b> profile!',
            // repositories
            301 => 'User <b>:user</b> register <b>:repository</b> repository in system!',
            302 => 'User <b>:user</b> modify <b>:repository</b> repository setting!',
            303 => 'User <b>:user</b> deleted <b>:repository</b> repository from system!',
            // backups
            401 => 'User <b>:user</b> created <b>:repository</b> repository backup!',
            402 => 'User <b>:user</b> restored backup in repository <b>:repository</b>!',
            403 => 'User <b>:user</b> deleted backup from repository <b>:repository</b>!',
        ];

        if (isset($messages[$msd_id])) {
            return strtr($messages[$msd_id], $msg_params);
        }

        return false;
    }

    /**
     * @param int $msg_id
     * @param array $params
     * @return bool
     */
    public static function setLog($msg_id, $params)
    {
        /** @var Users $user */
        $user = Yii::$app->user->identity;

        $msg_params = [':user' => $user->getName()];
        $msg_params = array_merge($msg_params, $params);

        $message = self::getMessageText($msg_id, $msg_params);

        $log = new self([
            'user_id' => $user->id,
            'action' => $message,
            'time' => Yii::$app->formatter->asTimestamp('now'),
        ]);

        return $log->save();
    }

    /**
     * Render last logs
     *
     * @param int $length
     * @return string
     */
    public static function getLastNotifications($length = 3)
    {
        $logs = Logs::find()->limit($length)->orderBy(['id' => SORT_DESC])->all();

        return Yii::$app->view->render('/log/notifications', ['logs' => $logs]);
    }

}
