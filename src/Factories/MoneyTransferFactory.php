<?php

namespace QuetzalStudio\Flip\Factories;

use QuetzalStudio\Flip\Models\MoneyTransfer;

class MoneyTransferFactory
{
    public static function make(array $attributes)
    {
        return new MoneyTransfer(
            data_get($attributes, 'account_number'),
            data_get($attributes, 'bank_code'),
            data_get($attributes, 'amount'),
            data_get($attributes, 'remark', ''),
            data_get($attributes, 'recipient_city', 0),
            data_get($attributes, 'beneficiary_email', ''),
        );
    }
}
