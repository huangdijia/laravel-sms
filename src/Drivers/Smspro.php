<?php

namespace Huangdijia\Sms\Drivers;

use Exception;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Smspro implements Driver
{
    protected $apis = [
        'send_sms'    => 'https://api3.hksmspro.com/service/smsapi.asmx/SendSMS',
        'get_balance' => 'https://api3.hksmspro.com/service/smsapi.asmx/GetBalance',
    ];
    protected $config;
    protected static $stateMap = [
        1   => 'Message	Sent',
        0   => 'Missing	Values',
        10  => 'Incorrect Username or Password',
        20  => 'Message content too long',
        30  => 'Message content too long',
        40  => 'Telephone number too long',
        60  => 'Incorrect Country Code',
        70  => 'Balance not enough',
        80  => 'Incorrect date time',
        100 => 'System error, please try again',
    ];

    /**
     * Construct
     * @param array $config 
     * @return void 
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Send
     * @param mixed $to 
     * @param mixed $content 
     * @return true 
     * @throws Exception 
     * @throws RequestException 
     */
    public function send(string $to, string $content)
    {
        $data = array(
            "Username"     => $this->config['username'],
            "Password"     => $this->config['password'],
            "Telephone"    => $to,
            "UserDefineNo" => "00000",
            "Hex"          => "",
            "Message"      => $content, //self::msgEncode($message),
            "Sender"       => $this->config['sender'],
        );

        $response = Http::asForm()->post($this->apis['send_sms'], $data)->throw();
        $content  = trim($response->body());

        throw_if($content == '', new Exception('Response body is empty!', 402));

        try {
            $result = simplexml_load_string($content);
            $result = json_encode($result);
            $result = json_decode($result);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 403);
        }

        throw_if($result->State != 1, new Exception(self::$stateMap[$result->State] ?? 'Unknown error', 500));

        return true;
    }

    /**
     * Get info
     * @return array 
     * @throws Exception 
     * @throws RequestException 
     */
    public function info()
    {
        $data = [
            'Username'     => $this->config['username'] ?? '',
            'Password'     => $this->config['password'] ?? '',
            'ResponseID'   => '',
            'UserDefineNo' => '',
        ];

        $response = Http::asForm()->post($this->apis['get_balance'], $data)->throw();
        $content  = trim($response->body());

        throw_if($content == '', new Exception('Response body is empty!', 402));

        try {
            $result = simplexml_load_string($content);
            $result = json_encode($result);
            $result = json_decode($result);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 403);
        }

        return [
            'account' => $this->config['username'],
            'balance' => $result->CurrentBalance ?? 0,
            'credit'  => $result->CreditLine ?? 0,
        ];
    }
}
