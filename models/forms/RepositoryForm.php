<?php

namespace app\models\forms;

use app\models\Repositories;
use app\models\Services;
use Yii;
use yii\base\Model;

class RepositoryForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $name;
    public $service_id;
    public $local_path;
    public $remote_path;
    public $has_auto_update;

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'service_id', 'local_path', 'remote_path', 'has_auto_update'];
        $scenarios[self::SCENARIO_UPDATE] = ['local_path', 'has_auto_update'];

        return $scenarios;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'service_id', 'local_path', 'remote_path'], 'required'],
            [['local_path', 'remote_path'], 'string', 'max' => 255],
            ['name', 'string', 'max' => 50],
            ['has_auto_update', 'boolean'],
            ['service_id', 'integer'],
            ['service_id', 'exist', 'targetClass' => Services::className(), 'targetAttribute' => 'id'],
            ['local_path', 'hasPermissionWriteHere']
        ];
    }

    /**
     * Checking permissions for write in this folder
     *
     * @param string $attribute
     */
    public function hasPermissionWriteHere($attribute)
    {
        try {
            $dir_info = new \DirectoryIterator($this->local_path);

            if (!$dir_info->isWritable()) {
                $this->addError($attribute, 'You do not have write access to this folder!');
            }
        } catch (\UnexpectedValueException $error) {
            $this->addError($attribute, 'Permission denied!');
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service',
        ];
    }

    /**
     * Register new repository
     *
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $repository = new Repositories([
            'name' => $this->name,
            'user_id' => Yii::$app->user->id,
            'service_id' => $this->service_id,
            'local_path' => $this->local_path,
            'remote_path' => $this->remote_path,
            'has_auto_update' => $this->has_auto_update,
        ]);

        return $repository->save();
    }

}