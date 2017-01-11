<?php

namespace app\components;

use app\models\Settings;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

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

    /**
     * Get folder for repository action
     *
     * @param string $repository - remote path
     * @param string $dir
     * @return string
     */
    public static function getRepositoryDir($repository, $dir = 'archives')
    {
        $backup_dir = Yii::getAlias(Settings::getSettingValue(Settings::SETTING_BACKUPS_DIR));
        return "{$backup_dir}/{$repository}/{$dir}";
    }

    /**
     * Create archive from folder
     *
     * @param string $name
     * @param string $source
     * @return bool|int
     */
    public static function createZipArchive($name, $source)
    {
        if (!class_exists('ZipArchive') || !file_exists($source)) {
            return false;
        }

        $zip = new \ZipArchive();
        if ($zip->open($name, \ZipArchive::CREATE) !== true) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source)) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                    continue;

                $file = str_replace('\\', '/', realpath($file));

                if (is_dir($file)) {
                    $zip->addEmptyDir(str_replace("{$source}/", '', "{$file}/"));
                } elseif (is_file($file)) {
                    clearstatcache(true, $file);
                    $zip->addFromString(str_replace("{$source}/", '', $file), file_get_contents($file));
                }
            }
        } elseif (is_file($source)) {
            clearstatcache(true, $source);
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        $num_files = $zip->numFiles;
        $zip->close();

        return $num_files;
    }

    /**
     * Save stream as file
     *
     * @param string $dir - save to
     * @param string $stream - download link
     * @param string $auth - authorization header
     * @return string - saved file name
     * @throws ErrorException
     */
    public static function saveStreamFile($dir, $stream, $auth = '')
    {
        @set_time_limit(100);

        if (!empty($auth)) {
            stream_context_set_default(['http' => ['header' => "Authorization: {$auth}"]]);
        }

        $headers = array_change_key_case(get_headers($stream, 1), CASE_LOWER);
        $content_disposition = ArrayHelper::getValue($headers, 'content-disposition');
        $filename = substr($content_disposition, (strrpos($content_disposition, '=') + 1));

        $backup_project_dir = FileSystem::getRepositoryDir($dir, 'tmp');
        $full_name = $backup_project_dir .'/'. $filename;

        if (!file_exists($backup_project_dir)) {
            mkdir($backup_project_dir, 0777, true);
        }

        if (file_put_contents($full_name, file_get_contents($stream))) {
            return $full_name;
        }

        throw new ErrorException('Archive not download!');
    }

    /**
     * Archive extract
     *
     * @param string $archive
     * @param string $extract_to
     * @return bool
     * @throws ErrorException
     */
    public static function extractArchive($archive, $extract_to = '')
    {
        @set_time_limit(100);
        $zip = new \ZipArchive();

        if ($extract_to) {
            $folder_name = $extract_to;
        } else {
            $filename = substr($archive, strrpos($archive, '/'));
            $folder_name = str_replace($filename, '', $archive);
        }

        if ($zip->open($archive) === true) {
            $zip->extractTo($folder_name);
            return $zip->close();
        } else {
            throw new ErrorException('Archive not extract!');
        }
    }

    /**
     * Copy files from folder
     *
     * @param string $from
     * @param string $to
     */
    public static function copyFiles($from, $to)
    {
        @set_time_limit(100);
        if ($handle = opendir($from)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != '.' && $entry != '..') {
                    if (is_dir("{$from}/{$entry}")) {
                        @mkdir("{$to}/{$entry}", 0755, true);
                        self::copyFiles("{$from}/{$entry}", "{$to}/{$entry}");
                    } else {
                        copy("{$from}/{$entry}", "{$to}/{$entry}");
                    }
                }
            }

            closedir($handle);
        }
    }

    /**
     * Remove dir with all files
     *
     * @param string $dir
     * @param bool   $include_self
     * @param array  $excluded_folders
     */
    public static function removeDir($dir, $include_self = true, $excluded_folders = [] )
    {
        @set_time_limit(5);
        if (is_dir($dir)) {
            $files = glob("{$dir}/{,.}*", GLOB_BRACE);

            foreach ($files as $file) {
                // Ignore ".", ".." and excluded folder
                if (in_array(substr($file, strrpos($file, '/') + 1), ['.', '..']) || in_array($file, $excluded_folders)) {
                    continue;
                }

                is_dir($file) ? self::removeDir($file, $include_self, $excluded_folders) : unlink($file);
            }

            if ($include_self) {
                rmdir($dir);
            }
        }

        if (is_file($dir)) {
            unlink($dir);
        }
    }

}