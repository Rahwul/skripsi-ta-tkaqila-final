<?php

namespace App\Services;

use Illuminate\Http\Client\Promises\LazyPromise;
use Illuminate\Http\Client\Response;

class ApiResponse
{
    protected Response $response;

    public function __construct($response)
    {
        if ($response instanceof LazyPromise) {
            $response = $response->wait();
        }

        $this->response = $response;
    }

    public function status(): int
    {
        return $this->response->status();
    }

    public function ok(): bool
    {
        return $this->response->ok();
    }

    public function successful(): bool
    {
        return $this->response->successful();
    }

    public function json($key = null, $default = null)
    {
        return $this->response->json($key, $default);
    }

    public function raw(): Response
    {
        return $this->response;
    }

    public function __call($name, $arguments)
    {
        return $this->response->{$name}(...$arguments);
    }
}
