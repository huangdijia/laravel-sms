<?php

namespace Huangdijia\Sms\Drivers;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Huangdijia\Sms\Contracts\Driver;
use Huangdijia\Sms\Response;

// Download：https://github.com/aliyun/openapi-sdk-php-client
// Usage：https://github.com/aliyun/openapi-sdk-php-client/blob/master/README-CN.md

class Aliyun implements Driver
{
    protected $config;

    /**
     * Construct
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = array_merge([
            'tries'         => 1,
            'access_key'    => '',
            'access_secret' => '',
        ], $config);

        AlibabaCloud::accessKeyClient($this->config['access_key'], $this->config['access_secret'])
            ->regionId('ap-southeast-1')
            ->asGlobalClient();
    }

    /**
     * Send
     * @param mixed $to
     * @param mixed $content
     * @return null
     */
    public function send(string $to, string $content)
    {
        if (preg_match('/^\d{8}$/', $to)) { // HK
            $to = '852' . $to;
        } elseif (preg_match('/^0\d{8}/', $to)) { // TW
            $to = '886' . $to;
        } elseif (preg_match('/^1\d{10}/', $to)) { // CN
            $to = '86' . $to;
        }

        return retry($this->config['tries'] ?? 1, function () use ($to, $content) {
            try {
                $result = AlibabaCloud::rpcRequest()
                    ->product('Dysmsapi')
                    ->host('dysmsapi.ap-southeast-1.aliyuncs.com')
                    ->version('2018-05-01')
                    ->action('SendMessageToGlobe')
                    ->method('POST')
                    ->options([
                        'query' => [
                            "To"      => $to,
                            // "From" => "1234567890",
                            "Message" => $content,
                        ],
                    ])
                    ->request();
                // print_r($result->toArray());
                return new Response(response()->json($result));
            } catch (ClientException $e) {
                // echo $e->getErrorMessage() . PHP_EOL;
                throw $e;
            } catch (ServerException $e) {
                // echo $e->getErrorMessage() . PHP_EOL;
                throw $e;
            }
        });
    }

    /**
     * Get the info of account
     * @return array
     */
    public function info()
    {
        return [];
    }
}
