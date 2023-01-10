<?php

namespace QuetzalStudio\Flip\Factories;

use QuetzalStudio\Flip\Models\SpecialMoneyTransfer;

class SpecialMoneyTransferFactory
{
    public static function make(array $attributes)
    {
        return new SpecialMoneyTransfer(
            data_get($attributes, 'account_number'),
            data_get($attributes, 'bank_code'),
            data_get($attributes, 'direction'),
            data_get($attributes, 'amount'),
            data_get($attributes, 'sender_country'),
            data_get($attributes, 'sender_name'),
            data_get($attributes, 'sender_identity_number'),
            data_get($attributes, 'sender_job'),
            data_get($attributes, 'remark', ''),
            data_get($attributes, 'recipient_city', 0),
            data_get($attributes, 'sender_place_of_birth', 0),
            data_get($attributes, 'sender_date_of_birth', ''),
            data_get($attributes, 'sender_identity_type', ''),
            data_get($attributes, 'sender_address', ''),
            data_get($attributes, 'beneficiary_email', ''),
        );
    }
}
