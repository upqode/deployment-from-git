<?php

namespace app\components;

use app\models\Backups;
use app\models\Repositories;
use yii\base\ErrorException;

class Deployment
{

    /**
     * Install commit or branch
     *
     * @param Repositories $repository
     * @param string $commit
     * @return bool|string
     */
    public static function installCommit(Repositories $repository, $commit)
    {
        try {
            // create local backup
            Backups::createBackup($repository);

            // save remote archive
            $saved_file = $repository->saveRemoteArchive($commit);

            // extract remote archive in tmp dir
            FileSystem::extractArchive($saved_file);

            // clear previous version
            FileSystem::removeDir($repository->local_path, false);

            // copy new files
            $repository_extract_folder = str_replace('.zip', '', $saved_file);
            FileSystem::copyFiles($repository_extract_folder, $repository->local_path);

            // remove tmp files
            FileSystem::removeDir($repository_extract_folder);
            FileSystem::removeDir($saved_file);
        } catch (ErrorException $error) {
            return $error->getMessage();
        }

        return true;
    }

}