<?php

namespace Huangdijia\Sms\Drivers;

use Exception;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Twsms implements Driver
{
    protected $apis = [
        'send_sms' => 'http://api.twsms.com/send.php',
    ];
    protected $config;

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
     * Get config
     * @return array 
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Send
     * @param mixed $to 
     * @param mixed $content 
     * @return true 
     * @throws RequestException 
     */
    public function send(string $to, string $content)
    {
        $data = [
            'username' => $this->config['account'],
            'password' => $this->config['password'],
            'type'     => $this->config['type'] ?? 'now',
            'encoding' => $this->config['encoding'] ?? 'big5',
            'vldtime'  => $this->config['vldtime'],
            'dlvtime'  => $this->config['dlvtime'],
            'mobile'   => $to,
            'message'  => iconv('utf-8', $this->config['encoding'] ?? 'big5' . '//IGNORE', $content),
        ];

        $response = Http::post($this->apis['send_sms'], $data)->throw();

        [$key, $msgid] = explode('=', $response->body());

        throw_if($msgid <= 0, new Exception("Send failed"));

        return true;
    }

    /**
     * Get info
     * @return array 
     */
    public function info()
    {
        return [];
    }
}
