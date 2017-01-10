<?php

namespace app\models\forms;

use app\models\ExcludeFolders;
use yii\base\Model;

class ExcludeFoldersForm extends Model
{
    public $folder;
    public $local_path;
    public $repository_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['folder', 'required'],
            ['folder', 'string', 'max' => 255],
            ['folder', 'hasPermissionWriteHere'],
            ['folder', 'validationLocalPath'],
            ['folder', 'unique', 'targetClass' => ExcludeFolders::className(), 'targetAttribute' => ['repository_id', 'folder'], 'message' => 'This folder has been excluded!'],
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
            $dir_info = new \DirectoryIterator($this->folder);

            if (!$dir_info->isWritable()) {
                $this->addError($attribute, 'You do not have write access to this folder!');
            }
        } catch (\UnexpectedValueException $error) {
            $this->addError($attribute, 'Permission denied!');
        }
    }

    /**
     * Check validation path
     *
     * @param string $attribute
     */
    public function validationLocalPath($attribute)
    {
        if ($this->folder === $this->local_path) {
            $this->addError($attribute, 'Root path of the project cannot be selected!');
        } elseif (false === strpos($this->folder, $this->local_path)) {
            $this->addError($attribute, 'You should select project folder!');
        }
    }

    /**
     * Save new excluded folder
     *
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $exclude_folder = new ExcludeFolders([
            'repository_id' => $this->repository_id,
            'folder' => $this->folder,
        ]);

        return $exclude_folder->save();
    }

}