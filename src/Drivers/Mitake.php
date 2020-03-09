<?php

namespace Huangdijia\Sms\Drivers;

use Exception;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Mitake implements Driver
{
    protected $apis = [
        'send_sms' => 'http://smexpress.mitake.com.tw:9600/SmSendGet.asp',
    ];
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
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
            'username' => $this->config['username'],
            'password' => $this->config['password'],
            'type'     => $this->config['type'] ?? 'now',
            'encoding' => $this->config['encoding'] ?? 'big5',
            'dstaddr'  => $to,
            'smbody'   => iconv('utf-8', $this->config['encoding'] ?? 'big5', $content),
            // 'vldtime'    => $this->config['vldtime'],
            // 'dlvtime'    => $this->config['dlvtime'],
        ];

        $response = Http::get($this->apis['send_sms'], $data)
            ->throw();

        $result = $this->parseReponse($response->body());

        throw_if(empty($result['statuscode']) || $result['statuscode'] != '1', new Exception($result['Error'], 1));

        return true;
    }

    /**
     * Get the info of account
     * @return array 
     */
    public function info()
    {
        return [];
    }

    /**
     * Parse respose
     * @param string $content
     * @return (int|string)[]|array
     */
    private function parseReponse($content = '')
    {
        $default = [
            'statuscode' => 0,
            'Error'      => 'Parse response failed',
        ];

        if (empty($content)) {
            return $default;
        }

        preg_match_all('/(\w+)=([^\r\n]+)/i', $content, $matches);
        if (empty($matches)) {
            return $default;
        }

        $result = [];
        foreach ($matches[1] as $i => $key) {
            $result[$key] = isset($matches[2][$i]) ? $matches[2][$i] : '';
            if ($key == 'Error') {
                $result[$key] = iconv('big5', 'utf-8', $result[$key]);
            }
        }

        $result = array_merge($default, $result);

        return $result;
    }
}
