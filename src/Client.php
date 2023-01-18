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
        $this->config = new Config(collect($options)->only([
            'environment',
            'client_key',
            'production_base_url',
            'sandbox_base_url',
        ])->toArray());

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

    /**
     * Set idempotency key
     *
     * @param string $key
     * @return self
     */
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
            $response = $this->pendingRequest->$method(...$arguments);

            RequestLogger::dispatch($response);

            $this->pendingRequest = null;

            if ($this->throwError) {
                $response = $response->throw();
            }

            return $response;
        }

        $this->pendingRequest->$method(...$arguments);

        return $this;
    }
}
