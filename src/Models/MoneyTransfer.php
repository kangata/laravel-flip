<?php

namespace QuetzalStudio\Flip\Models;

use Illuminate\Contracts\Support\Arrayable;

class MoneyTransfer implements Arrayable
{
    protected string $accountNumber;

    protected string $bankCode;

    protected int $amount;

    protected string $remark;

    protected int $recipientCity;

    protected string $beneficiaryEmail;

    public function __construct(
        $accountNumber,
        $bankCode,
        $amount,
        $remark = '',
        $recipientCity = 0,
        $beneficiaryEmail = ''
    ) {
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->amount = $amount;
        $this->remark = $remark;
        $this->recipientCity = $recipientCity;
        $this->beneficiaryEmail = $beneficiaryEmail;
    }

    public function toArray()
    {
        return [
            'account_number' => $this->accountNumber,
            'bank_code' => $this->bankCode,
            'amount' => $this->amount,
            'remark' => $this->remark,
            'recipient_city' => $this->recipientCity,
            'beneficiary_email' => $this->beneficiaryEmail,
        ];
    }
}
