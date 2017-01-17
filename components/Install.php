<?php

namespace app\components;

use app\models\Users;
use Yii;

class Install
{

    /**
     * Check need installing system or not?
     *
     * @return bool
     */
    public static function needInstalling()
    {
        // db not imported
        if (empty(Yii::$app->db->schema->getTableNames())) {
            return true;
        }

        // administrator not created
        if (!Users::find()->count()) {
            return true;
        }

        return false;
    }

    /**
     * Install db scheme from sql files
     */
    public static function installDbScheme()
    {
        $folder = Yii::getAlias('@app/migrations/sql');
        $system_version = Yii::$app->version;

        foreach (glob("{$folder}/*.sql") as $file) {
            $file_version = substr($file, (strrpos($file, '/') + 9), 5);

            if (version_compare($file_version, $system_version, '>=')) {
                Yii::$app->db->createCommand(file_get_contents($file))->execute();
            }
        }
    }

}