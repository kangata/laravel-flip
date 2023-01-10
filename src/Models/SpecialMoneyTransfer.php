<?php

namespace QuetzalStudio\Flip\Models;

use Illuminate\Contracts\Support\Arrayable;

class SpecialMoneyTransfer implements Arrayable
{
    protected string $accountNumber;

    protected string $bankCode;

    protected string $direction;

    protected int $amount;

    protected int $senderCountry;

    protected string $senderName;

    protected string $senderIdentityNumber;

    protected string $senderJob;

    protected string $remark;

    protected int $recipientCity;

    protected int $senderPlaceOfBirth;

    protected string $senderDateOfBirth;

    protected string $senderIdentityType;

    protected string $senderAddress;

    protected string $beneficiaryEmail;

    public function __construct(
        $accountNumber,
        $bankCode,
        $direction,
        $amount,
        $senderCountry,
        $senderName,
        $senderIdentityNumber,
        $senderJob,
        $remark = '',
        $recipientCity = 0,
        $senderPlaceOfBirth = 0,
        $senderDateOfBirth = '',
        $senderIdentityType = '',
        $senderAddress = '',
        $beneficiaryEmail = ''
    ) {
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->direction = $direction;
        $this->amount = $amount;
        $this->senderCountry = $senderCountry;
        $this->senderName = $senderName;
        $this->senderIdentityNumber = $senderIdentityNumber;
        $this->senderJob = $senderJob;
        $this->remark = $remark;
        $this->recipientCity = $recipientCity;
        $this->senderPlaceOfBirth = $senderPlaceOfBirth;
        $this->senderDateOfBirth = $senderDateOfBirth;
        $this->senderIdentityType = $senderIdentityType;
        $this->senderAddress = $senderAddress;
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
            'sender_country' => $this->senderCountry,
            'sender_place_of_birth' => $this->senderPlaceOfBirth,
            'sender_date_of_birth' => $this->senderDateOfBirth,
            'sender_identity_type' => $this->senderIdentityType,
            'sender_name' => $this->senderName,
            'sender_address' => $this->senderAddress,
            'sender_identity_number' => $this->senderIdentityNumber,
            'sender_job' => $this->senderJob,
            'direction' => $this->direction,
            'beneficiary_email' => $this->beneficiaryEmail,
        ];
    }
}
