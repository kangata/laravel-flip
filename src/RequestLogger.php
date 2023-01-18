<?php

namespace QuetzalStudio\Flip;

use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class RequestLogger
{
    protected Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public static function dispatch(Response $response)
    {
        return new static($response);
    }

    /**
     * Get logger instance
     *
     * @return Logger|null
     */
    public function log()
    {
        if (is_null(Flip::$logChannel)) {
            return null;
        }

        return Log::channel(Flip::$logChannel);
    }

    /**
     * Get log message
     *
     * @param Request $request
     * @return string
     */
    public function message(Request $request)
    {
        return implode(' ', [
            (string) $request->getMethod(),
            (string) $request->getUri(),
            $this->response->status(),
        ]);
    }

    /**
     * Get request context
     *
     * @param Request $request
     * @return array
     */
    public function requestContext(Request $request)
    {
        $reqBody = [];
        $reqHeaders = $request->getHeaders();

        parse_str((string) $request->getBody(), $reqBody);

        $reqHeaders['Authorization'] = ['**********'];

        return [
            'body' => $reqBody,
            'headers' => $reqHeaders,
        ];
    }

    /**
     * Get response context
     *
     * @return array
     */
    public function responseContext()
    {
        return [
            'body' => $this->response->json(),
            'headers' => $this->response->headers(),
        ];
    }

    public function __destruct()
    {
        if (! $this->log()) {
            return;
        }

        try {
            $request = $this->response->transferStats->getRequest();

            $this->log()->debug($this->message($request), [
                'request' => $this->requestContext($request),
                'response' => $this->responseContext(),
            ]);
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}
