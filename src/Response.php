<?php

namespace Huangdijia\Sms;

use Throwable;

class Response
{
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
     * @return mixed
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
}
