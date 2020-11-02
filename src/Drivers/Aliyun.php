<?php

namespace Huangdijia\Sms\Drivers;

use AlibabaCloud\Client\AlibabaCloud;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\Response;
use InvalidArgumentException;
use RuntimeException;

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
            'template_code' => '',
        ], $config);

        AlibabaCloud::accessKeyClient($this->config['access_key'], $this->config['access_secret'])
            ->regionId('ap-southeast-1')
            ->asGlobalClient();
    }

    /**
     * Send
     * @param mixed $to
     * @param mixed $content
     * @return \Illuminate\Http\Client\Response
     */
    public function send(string $to, string $content)
    {
        throw_if($to == '', new InvalidArgumentException('$to is empty!'));
        throw_if($content == '', new InvalidArgumentException('$content is empty!'));

        $action = 'SendMessageToGlobe';

        if (preg_match('/^861\d{10}/', $to)) { // CN
            $action = 'SendMessageWithTemplate';
        }

        return retry($this->config['tries'] ?? 1, function () use ($to, $content, $action) {
            return tap(
                new Response(
                    AlibabaCloud::rpcRequest()
                        ->product('Dysmsapi')
                        ->host('dysmsapi.ap-southeast-1.aliyuncs.com')
                        ->version('2018-05-01')
                        ->action($action)
                        ->method('POST')
                        ->options([
                            'query' => [
                                "To"      => $to,
                                "Message" => $content,
                            ],
                        ])
                        ->request()
                ),
                function ($response) {
                    /** @var Response $response */
                    throw_if($response->json('ResponseCode') != 'OK', new RuntimeException($response->json('ResponseDescription')));
                });
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
