<?php

namespace app\components;

use app\models\Repositories;
use yii\httpclient\Client;

class BitBucket
{
    private static $baseUrl = 'https://bitbucket.org/api/2.0';

    /**
     * Test connection from BitBucket
     *
     * @param string $username
     * @param string $access_token
     * @return bool
     */
    public static function testApiConnection($username, $access_token)
    {
        $client = new Client(['baseUrl' => self::$baseUrl]);
        $request = $client->createRequest()
            ->setUrl('repositories/'. $username)
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders(['Authorization' => 'Basic '. base64_encode($username .':'. $access_token)])
            ->send();

        if ($request->isOk) {
            return $request->data['size'];
        }

        return false;
    }

    /**
     * Get repositories list
     *
     * @param string $username
     * @param string $access_token
     * @return array
     */
    public static function getRepositoriesList($username, $access_token)
    {
        $client = new Client(['baseUrl' => self::$baseUrl]);
        $request = $client->createRequest()
            ->setUrl('repositories/'. $username)
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders(['Authorization' => 'Basic '. base64_encode($username .':'. $access_token)])
            ->send();

        if ($request->isOk) {
            if (isset($request->data['values'])) {
                return $request->data['values'];
            }
        }

        return array();
    }

    /**
     * Get commits
     *
     * @param Repositories $repository
     * @return array
     */
    public static function getCommits(Repositories $repository)
    {
        $client = new Client(['baseUrl' => self::$baseUrl]);
        $request = $client->createRequest()
            ->setUrl("repositories/{$repository->remote_path}/commits")
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders(['Authorization' => 'Basic '. base64_encode($repository->service->username .':'. $repository->service->access_token)])
            ->send();

        if ($request->isOk) {
            if (isset($request->data['values'])) {
                return $request->data['values'];
            }
        }

        return array();
    }

    /**
     * Get branches
     *
     * @param Repositories $repository
     * @param string $branch
     * @return array
     */
    public static function getBranches(Repositories $repository, $branch = '')
    {
        $client = new Client(['baseUrl' => self::$baseUrl]);
        $request = $client->createRequest()
            ->setUrl("repositories/{$repository->remote_path}/refs/branches/{$branch}")
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders(['Authorization' => 'Basic '. base64_encode($repository->service->username .':'. $repository->service->access_token)])
            ->send();

        if ($request->isOk) {
            if ($branch) {
                return $request->data;
            } elseif (isset($request->data['values'])) {
                return $request->data['values'];
            }
        }

        return array();
    }

    /**
     * Download repository archive
     *
     * @param Repositories $repository
     * @param string $commit
     * @return string
     */
    public static function saveArchive(Repositories $repository, $commit)
    {
        $url = "https://bitbucket.org/{$repository->remote_path}/get/{$commit}.zip";
        $authorization = 'Basic '. base64_encode($repository->service->username .':'. $repository->service->access_token);

        return FileSystem::saveStreamFile($repository->remote_path, $url, $authorization);
    }

}