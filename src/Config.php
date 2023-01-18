<?php

namespace QuetzalStudio\Flip;

class Config
{
    private string $environment;

    private string $clientKey;

    private string $baseUrl;

    public function __construct(array $options = [])
    {
        if (empty($options)) {
            $this->useDefaultConfig();
        } else {
            $this->useCustomConfig($options);
        }
    }

    /**
     * Setup with default config
     *
     * @return void
     */
    public function useDefaultConfig()
    {
        $this->environment = config('flip.environment');
        $this->clientKey = config('flip.client_key');
        $this->baseUrl = config("flip.{$this->environment}_base_url");
    }

    /**
     * Setup with custom config
     *
     * @param array $options
     * @return void
     */
    public function useCustomConfig(array $options)
    {
        $this->environment = data_get($options, 'environment', '');
        $this->clientKey = data_get($options, 'client_key', '');
        $this->baseUrl = data_get($options, "{$this->environment}_base_url", '');
    }

    /**
     * Get client key
     *
     * @return string
     */
    public function clientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Get base url
     *
     * @return string
     */
    public function baseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get auth token
     *
     * @return string
     */
    public function token(): string
    {
        return base64_encode($this->clientKey.':');
    }

    /**
     * Get API URL
     *
     * @param string $endpoint
     * @return string
     */
    public function url(string $endpoint): string
    {
        if (preg_match('/\./', $endpoint)) {
            $endpoint = config("flip.endpoints.{$endpoint}");
        }

        return $this->baseUrl.$endpoint;
    }
}
