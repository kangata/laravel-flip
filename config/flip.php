<?php

return [
    'environment' => env('FLIP_ENV', 'sandbox'),

    'client_key' => env('FLIP_CLIENT_KEY'),

    'production_base_url' => env('FLIP_PRODUCTION_BASE_URL', 'https://bigflip.id/big_sandbox_api'),

    'sandbox_base_url' => env('FLIP_SANDBOX_BASE_URL', 'https://bigflip.id/big_sandbox_api'),

    'endpoints' => [
        'v2' => [
            'get_balance' => '/v2/general/balance',
            'get_banks' => '/v2/general/banks',
            'maintenance_status' => '/v2/general/maintenance',

            'bank_account_inquiry' => '/v2/disbursement/bank-account-inquiry',
            'get_countries' => '/v2/disbursement/country-list',
            'get_cities' => '/v2/disbursement/city-list',
        ],

        'v3' => [
            'money_transfer' => '/v3/disbursement',
            'special_money_transfer' => '/v3/special-disbursement',
            'get_disbursements' => '/v3/disbursement',
            'find_disbursement' => '/v3/get-disbursement',
        ]
    ],
];
