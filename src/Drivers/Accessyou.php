<?php

namespace Huangdijia\Sms\Drivers;

use Exception;
use Huangdijia\Sms\Contracts\Driver;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class Accessyou implements Driver
{
    private $apis = [
        'send_sms'      => 'http://api.accessyou.com/sms/sendsms.php',
        'check_accinfo' => 'https://q.accessyou-api.com/sms/check_accinfo.php?accountno=%s&user=%s&pwd=%s',
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
     * Send
     * @param mixed $to 
     * @param mixed $content 
     * @return true 
     * @throws RequestException 
     */
    public function send(string $to, string $content)
    {
        $data = [
            'msg'       => self::msgEncode($content),
            'phone'     => '852' . $to,
            'accountno' => $this->config['account'],
            'pwd'       => $this->config['password'],
        ];

        $response = Http::get($this->apis['send_sms'], $data)
            ->throw();

        $content = trim($response->body());

        throw_if($content == '', new Exception("Response body is empty!"));

        throw_if(!is_numeric($content), new Exception($content));

        return true;
    }

    /**
     * Get the info of account
     * @return array 
     * @throws RequestException 
     */
    public function info()
    {
        $url = sprintf(
            $this->apis['check_accinfo'],
            $this->config['account'],
            $this->config['check_user'],
            $this->config['check_password']
        );

        $response = Http::get($url)->throw();

        $xml = simplexml_load_string($response);
        $xml = json_encode($xml);
        $xml = json_decode($xml);

        throw_if(($xml->auth->auth_status ?? '') != 100, new Exception($xml->auth->auth_status_desc ?? '', $xml->auth->auth_status ?? 1));

        return [
            'account_no'  => $xml->balanceinfo->account_no ?? '',
            'balance'     => $xml->balanceinfo->balance ?? '',
            'expiry_date' => $xml->balanceinfo->expiry_date ?? '',
        ];
    }

    /**
     * Encode sms content
     * @param string $str 
     * @return string|string[]|null 
     */
    private static function msgEncode($str = '')
    {
        return self::unicodeGet(self::convert(2, $str));
    }

    /**
     * Replace chars
     * @param mixed $str 
     * @return string|string[]|null 
     */
    private static function unicodeGet($str)
    {
        $str = preg_replace("/&#/", "%26%23", $str);
        $str = preg_replace("/;/", "%3B", $str);
        return $str;
    }

    /**
     * Convert
     * @param mixed $language 
     * @param mixed $cell 
     * @return string|void 
     */
    private static function convert($language, $cell)
    {
        $str = "";
        preg_match_all("/[\x80-\xff]?./", $cell, $ar);

        switch ($language) {
            case 0: // 繁体中文
                foreach ($ar[0] as $v) {
                    $str .= "&#" . self::chineseUnicode(iconv("big5-hkscs", "UTF-8", $v)) . ";";
                }
                return $str;
                break;
            case 1: // 简体中文
                foreach ($ar[0] as $v) {
                    $str .= "&#" . self::chineseUnicode(iconv("gb2312", "UTF-8", $v)) . ";";
                }
                return $str;
                break;
            case 2: // 二进制编码
                $cell = self::utf8Unicode($cell);
                foreach ($cell as $v) {
                    $str .= "&#" . $v . ";";
                }
                return $str;
                break;
        }
    }

    /**
     * encode unicode
     * @param mixed $c 
     * @return int|void 
     */
    private static function chineseUnicode($c)
    {
        switch (strlen($c)) {
            case 1:
                return ord($c);
            case 2:
                $n = (ord($c[0]) & 0x3f) << 6;
                $n += ord($c[1]) & 0x3f;
                return $n;
            case 3:
                $n = (ord($c[0]) & 0x1f) << 12;
                $n += (ord($c[1]) & 0x3f) << 6;
                $n += ord($c[2]) & 0x3f;
                return $n;
            case 4:
                $n = (ord($c[0]) & 0x0f) << 18;
                $n += (ord($c[1]) & 0x3f) << 12;
                $n += (ord($c[2]) & 0x3f) << 6;
                $n += ord($c[3]) & 0x3f;
                return $n;
        }
    }

    /**
     * encode utf8 unicode
     * @param mixed $str 
     * @return array 
     */
    private static function utf8Unicode($str)
    {
        $unicode    = [];
        $values     = [];
        $lookingFor = 1;

        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);

            if ($thisValue < 128) {
                $unicode[] = $thisValue;
            } else {
                if (count($values) == 0) {
                    $lookingFor = ($thisValue < 224) ? 2 : 3;
                }

                $values[] = $thisValue;

                if (count($values) == $lookingFor) {
                    $number = ($lookingFor == 3) ? (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64) : (($values[0] % 32) * 64) + ($values[1] % 64);

                    $unicode[]  = $number;
                    $values     = [];
                    $lookingFor = 1;
                }
            }
        }

        return $unicode;
    }
}
