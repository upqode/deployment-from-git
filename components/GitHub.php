<?php

namespace app\components;

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

}