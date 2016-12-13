<?php

namespace app\components;

use app\models\Repositories;
use yii\httpclient\Client;

class GitHub
{
    private static $baseUrl = 'https://api.github.com';

    /**
     * Test connection from GitHub
     *
     * @param string $username
     * @param string $access_token
     * @return bool
     */
    public static function testApiConnection($username, $access_token)
    {
        $client = new Client(['baseUrl' => self::$baseUrl]);
        $request = $client->createRequest()
            ->setUrl('user')
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders([
                'User-Agent' => $username,
                'Authorization' => 'Basic '. base64_encode($username .':'. $access_token)
            ])
            ->send();

        if ($request->isOk) {
            return true;
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
            ->setUrl('user/repos')
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders([
                'User-Agent' => $username,
                'Authorization' => 'Basic '. base64_encode($username .':'. $access_token)
            ])
            ->send();

        if ($request->isOk) {
            return $request->data;
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
            ->setUrl("repos/{$repository->remote_path}/commits")
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders([
                'User-Agent' => $repository->service->username,
                'Authorization' => 'Basic '. base64_encode($repository->service->username .':'. $repository->service->access_token)
            ])
            ->send();

        if ($request->isOk) {
            return $request->data;
        }

        return array();
    }

}