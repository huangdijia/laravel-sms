<?php

namespace Huangdijia\Sms\Drivers;

use Exception;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Mxtong implements Driver
{
    protected $apis = [
        'send_sms' => 'http://61.143.63.169:8080/GateWay/Services.asmx/DirectSend',
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
     * @throws Exception
     * @throws RequestException
     */
    public function send(string $to, string $content)
    {
        $data = [
            'Phones'        => $to,
            'Content'       => $content,
            'SendTime'      => '',
            'UserId'        => $this->config['user_id'],
            'Account'       => $this->config['account'],
            'Password'      => $this->config['password'],
            'SendType'      => $this->config['send_type'] ?? 1,
            'PostFixNumber' => $this->config['post_fix_number'] ?? 1,
        ];

        $response = Http::asForm()
            ->post($this->apis['send_sms'], $data)
            ->throw();

        if ($response->body() == '') {
            throw new Exception("Response body is empty!", 401);
        }

        $XmlObj = false;

        try {
            $content = preg_replace('/<ROOT[^>]+>/', '<ROOT>', $response->body());
            $XmlObj  = simplexml_load_string($content);
        } catch (Exception $e) {
            throw new Exception('Parse xml error:' . $e->getMessage(), 402);
        }

        throw_if(false === $XmlObj || !is_object($XmlObj),
            new Exception('Parse xml failed', 402)
        );

        throw_if(!isset($XmlObj->RetCode) || $XmlObj->RetCode != 'Sucess',
            new Exception('Sended failed:' . $XmlObj->Message, 402)
        );

        throw_if(isset($XmlObj->OKPhoneCounts) && 0 == $XmlObj->OKPhoneCounts,
            new Exception('Sended all failed:' . $XmlObj->Message, 403)
        );

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
