<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.base_url', env('API_BASE_URL', 'http://localhost:3000')), '/');
    }

    protected function client()
    {
        $request = Http::baseUrl($this->baseUrl)->acceptJson();

        if (Session::has('api_token')) {
            $request = $request->withToken(Session::get('api_token'));
        }

        return $request;
    }

    public function get(string $uri, array $query = []): \App\Services\ApiResponse
    {
        return new \App\Services\ApiResponse(
            $this->client()->get($uri, $query)
        );
    }

    public function post(string $uri, array $data = []): \App\Services\ApiResponse
    {
        return new \App\Services\ApiResponse(
            $this->client()->post($uri, $data)
        );
    }

    public function put(string $uri, array $data = []): \App\Services\ApiResponse
    {
        return new \App\Services\ApiResponse(
            $this->client()->put($uri, $data)
        );
    }

    public function patch(string $uri, array $data = []): \App\Services\ApiResponse
    {
        return new \App\Services\ApiResponse(
            $this->client()->patch($uri, $data)
        );
    }

    public function delete(string $uri): \App\Services\ApiResponse
    {
        return new \App\Services\ApiResponse(
            $this->client()->delete($uri)
        );
    }
}
