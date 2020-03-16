<?php

namespace Huangdijia\Sms;

use Throwable;

class Response
{
    /**
     * @var \Illuminate\Http\Client\Response
     */
    protected $response;
    protected $exception;

    /**
     * Construct
     * @param mixed $response
     * @param Throwable|null $exception
     * @return void
     */
    public function __construct($response, Throwable $exception = null)
    {
        $this->response  = $response;
        $this->exception = $exception;
    }

    /**
     * Get the response
     * @return \Illuminate\Http\Client\Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Determine if the request was successful.
     * @return bool
     */
    public function successful()
    {
        return is_null($this->exception);
    }

    /**
     * Throw an exception if a server or client error occurred.
     *
     * @return $this
     *
     * @throws \Throwable
     */
    function throw () {
        if ($this->successful()) {
            return $this;
        }

        throw $this->exception;
    }

    /**
     * call
     * @param string $name 
     * @param array|null $arguments 
     * @return mixed 
     */
    public function __call($name, $arguments)
    {
        return $this->response->{$name}(...$arguments);
    }
}
