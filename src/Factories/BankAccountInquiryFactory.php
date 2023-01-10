<?php

namespace QuetzalStudio\Flip\Factories;

use QuetzalStudio\Flip\Models\BankAccountInquiry;

class BankAccountInquiryFactory
{
    public static function make(array $attributes)
    {
        return new BankAccountInquiry(
            data_get($attributes, 'account_number'),
            data_get($attributes, 'bank_code'),
            data_get($attributes, 'inquiry_key'),
        );
    }
}
