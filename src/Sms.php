<?php

namespace Huangdijia\Sms;

use Huangdijia\Sms\Contracts\Driver;
use Huangdijia\Sms\Response;
use InvalidArgumentException;
use Throwable;

class Sms
{
    protected $content;
    protected $driver;
    protected $to;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Set to
     * @param string $to 
     * @return $this 
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Set content
     * @param string $content 
     * @return $this 
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Send
     * @return Response|void 
     */
    public function send()
    {
        try {
            if ('' == $this->to) {
                throw new InvalidArgumentException("to is empty.", 1);
            }

            if ('' == $this->content) {
                throw new InvalidArgumentException("content is empty.", 1);
            }

            return new Response($this->driver->send($this->to, $this->content));
        } catch (Throwable $e) {
            return new Response('', $e);
        }
    }

    /**
     * Get info
     * @return array 
     */
    public function info()
    {
        return $this->driver->info();
    }
}
