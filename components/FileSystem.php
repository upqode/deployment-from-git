<?php

namespace app\components;

use yii\base\ErrorException;

class FileSystem
{

    /**
     * Get path info and directory list in it
     *
     * @param string $dir
     * @return array
     */
    public static function getDirInfo($dir = '')
    {
        $dir_list = array();

        if ($dir) {
            try { // if access denied
                chdir($dir);
            } catch (ErrorException $error) { // return empty result
                return ['dir_list' => ['..']];
            }
        }

        if ($handle = opendir(getcwd())) {
            while (false !== ($entry = readdir($handle))) {
                if (is_dir($entry)) {
                    $dir_list[] = $entry;
                }
            }

            closedir($handle);
        }

        $dir_list = preg_grep('/^([^.])/', $dir_list); // remove folders with "." in early
        array_unshift($dir_list, '..'); // for level up

        return ['path' => getcwd(), 'dir_list' => $dir_list];
    }

}