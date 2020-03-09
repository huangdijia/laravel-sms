<?php

namespace Huangdijia\Sms;

use Huangdijia\Sms\Contracts\Driver;
use Huangdijia\Sms\Response;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
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
     * @return Response|void
     */
    public function send()
    {
        try {
            $validator = Validator::make(
                [
                    'to'      => $this->to,
                    'content' => $this->content,
                ],
                $this->rules,
                $this->messages,
            );

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first(), 1);
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
