<?php

namespace QuetzalStudio\Flip\Models;

use Illuminate\Contracts\Support\Arrayable;

class BankAccountInquiry implements Arrayable
{
    protected string $accountNumber;

    protected string $bankCode;

    protected ?string $inquiryKey = null;

    public function __construct(
        $accountNumber,
        $bankCode,
        $inquiryKey = null
    ) {
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->inquiryKey = $inquiryKey;
    }

    public function toArray()
    {
        return [
            'account_number' => $this->accountNumber,
            'bank_code' => $this->bankCode,
            'inquiry_key' => $this->inquiryKey,
        ];
    }
}
