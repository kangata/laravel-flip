<?php

namespace QuetzalStudio\Flip;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use QuetzalStudio\Flip\Models\BankAccountInquiry;
use QuetzalStudio\Flip\Models\MoneyTransfer;
use QuetzalStudio\Flip\Models\SpecialMoneyTransfer;

class Flip
{
    public static ?Client $client = null;

    public static bool $httpResponse = false;

    public static bool $throw = true;

    public static function client()
    {
        if (! static::$client) {
            static::$client = new Client([
                'throw' => static::$throw,
            ]);
        }

        return static::$client;
    }

    public static function url(string $endpoint)
    {
        return static::$client->config()->url($endpoint);
    }

    public static function useHttpResponse()
    {
        static::$httpResponse = true;
    }

    public static function disableThrow()
    {
        static::$throw = false;
    }

    public static function handleResponse(Response $response, string $key = null)
    {
        return static::$httpResponse ? $response : $response->json($key);
    }

    public static function balance()
    {
        $resp = static::client()->get(static::url('v2.get_balance'));

        return static::handleResponse($resp, 'balance');
    }

    public static function isMaintenance()
    {
        $resp = static::client()->get(static::url('v2.maintenance_status'));

        return static::handleResponse($resp, 'maintenance');
    }

    public static function banks()
    {
        $resp = static::client()->get(static::url('v2.get_banks'));

        return static::handleResponse($resp);
    }

    public static function countries()
    {
        $resp = static::client()->get(static::url('v2.get_countries'));

        return static::handleResponse($resp);
    }

    public static function cities()
    {
        $resp = static::client()->get(static::url('v2.get_cities'));

        return static::handleResponse($resp);
    }

    public static function getDisbursements(array $params)
    {
        $resp = static::client()->get(
            static::url('v3.get_disbursements'),
            $params
        );

        return static::handleResponse($resp);
    }

    public static function findDisbursement(string $value, string $key = 'idempotency-key')
    {
        $resp = static::client()->get(
            static::url('v3.find_disbursement')."?{$key}={$value}",
        );

        return static::handleResponse($resp);
    }

    public static function bankAccountInquiry(BankAccountInquiry $payload)
    {
        $resp = static::client()->post(
            static::url('v2.bank_account_inquiry'),
            $payload->toArray()
        );

        if ($resp->json('code') == Error::VALIDATION_ERROR) {
            $psr7 = new Psr7Response(422, $resp->headers(), $resp->body());
            $resp = new Response($psr7);

            throw new RequestException($resp);
        }

        return static::handleResponse($resp);
    }

    public static function moneyTransfer(string $key, MoneyTransfer $payload)
    {
        $resp = static::client()->idempotencyKey($key)->post(
            static::url('v3.money_transfer'),
            $payload->toArray()
        );

        return static::handleResponse($resp);
    }

    public static function specialMoneyTransfer(string $key, SpecialMoneyTransfer $payload)
    {
        $resp = static::client()->idempotencyKey($key)->post(
            static::url('v3.special_money_transfer'),
            $payload->toArray()
        );

        return static::handleResponse($resp);
    }
}
