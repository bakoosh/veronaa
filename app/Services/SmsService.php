<?php

namespace App\Services;

use GuzzleHttp\Client;

class SmsService
{
    protected $login;
    protected $password;
    protected $sender;
    protected $client;

    public function __construct()
    {
        $this->login = config('smsc.login');
        $this->password = config('smsc.password');
        $this->sender = config('smsc.sender');
        $this->client = new Client();
    }

    public function sendSms($phone, $message)
    {
        $url = 'https://smsc.kz/sys/send.php';
        $params = [
            'login' => $this->login,
            'psw' => $this->password,
            'phones' => $phone,
            'mes' => $message,
            'sender' => $this->sender,
            'fmt' => 3,
        ];

        try {
            $response = $this->client->get($url, [
                'query' => $params,
                'verify' => false,
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {

            return ['error' => $e->getMessage()];
        }
    }


}

