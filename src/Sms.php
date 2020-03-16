<?php

namespace Huangdijia\Sms;

use Huangdijia\Sms\Contracts\Driver;
use Huangdijia\Sms\Response;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Sms
{
    protected $content;
    protected $driver;
    protected $to;
    protected $rules    = [];
    protected $messages = [];

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
     * Validate
     * @param array $rules
     * @param array $messages
     * @return $this
     */
    public function withRules(array $rules = [], array $messages = [])
    {
        $this->rules    = $rules;
        $this->messages = $messages;

        return $this;
    }

    /**
     * Send
     * @return Response
     */
    public function send()
    {
        try {
            Validator::make(
                [
                    'to'      => $this->to,
                    'content' => $this->content,
                ],
                $this->rules,
                $this->messages,
            )->validate();

            return new Response($this->driver->send($this->to, $this->content));
        } catch (Throwable $e) {
            return new Response(false, $e);
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
