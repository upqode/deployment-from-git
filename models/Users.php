<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $reset_key
 * @property integer $has_create
 * @property integer $has_edit
 * @property integer $has_delete
 * @property integer $has_update
 */
class Users extends ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'has_create', 'has_edit', 'has_delete', 'has_update'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Get user permission list
     *
     * @return string
     */
    public function getPermissionsList()
    {
        $permissions[] = $this->has_edit ? 'Edit repository' : false;
        $permissions[] = $this->has_create ? 'Create repository' : false;
        $permissions[] = $this->has_update ? 'Update repository' : false;
        $permissions[] = $this->has_delete ? 'Delete repository' : false;

        return implode('<br>', array_filter($permissions));
    }

}
