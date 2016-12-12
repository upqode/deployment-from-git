<?php

namespace app\components;

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

}