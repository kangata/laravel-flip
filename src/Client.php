<?php

namespace QuetzalStudio\Flip;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Client
{
    protected Config $config;

    protected ?PendingRequest $pendingRequest = null;

    protected bool $throwError;

    public function __construct(array $options = [])
    {
        $this->config = new Config();

        $this->throwError = data_get($options, 'throw', true);
    }

    /**
     * Get config
     *
     * @return Config
     */
    public function config(): Config
    {
        return $this->config;
    }

    public function idempotencyKey(string $key)
    {
        return $this->withHeaders([
            'idempotency-key' => $key,
        ]);
    }

    /**
     * The request headers
     *
     * @param array $headers
     * @return array
     */
    private function headers(array $headers = []): array
    {
        $headers['Authorization'] = 'Basic '.$this->config->token();

        return $headers;
    }

    public function __call($method, $arguments)
    {
        if (! $this->pendingRequest) {
            $this->pendingRequest = Http::asForm()->withHeaders($this->headers());
        }

        if ($method == 'withHeaders') {
            $this->pendingRequest->withHeaders(...$arguments);

            return $this;
        }

        if (in_array($method, ['get', 'post'])) {
            $http = $this->pendingRequest->$method(...$arguments);

            $this->pendingRequest = null;

            if ($this->throwError) {
                $http = $http->throw();
            }

            return $http;
        }

        $this->pendingRequest->$method(...$arguments);

        return $this;
    }
}
