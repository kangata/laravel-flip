# Flip API for Laravel

## Installation
```
composer require quetzal-studio/laravel-flip
```

```
FLIP_ENV=sandbox // or production
FLIP_CLIENT_KEY=YOUR_FLIP_CLIENT_KEY
```

## Example Usage
```
use QuetzalStudio\Flip\Flip;

try {
    Flip::balance();
} catch (\Illuminate\Http\Client\RequestException $e) {
    // handle request exception
} catch (\Exception $e) {
    // handle exception
}
```

### Get Balance
```
Flip::balance();
```

### Get Maintenance Status
```
Flip::balance();
```

### Get Banks
```
Flip::banks();
```

### Get Countries
```
Flip::countries();
```

### Get Cities
```
Flip::cities();
```

### Get disbursement
> for params you can see details at https://docs.flip.id/#get-all-disbursement-v3
```
Flip::getDisbursements();

Flip::getDisbursements(['page' => 2]);
```

### Find disbursement
> by default it will find by idempotency-key
```
Flip::findDisbursement('KEY1002');

Flip::findDisbursement('10', 'id');
```

### Bank Account Inquiry
```
$account = \QuetzalStudio\Flip\Factories\BankAccountInquiryFactory::make([
    "account_number" => "1122333301",
    "bank_code" => "bni",
    "inquiry_key" => \Illuminate\Support\Str::random(8),
]);

Flip::bankAccountInquiry($account);
```

### Create Money Transfer / Create Disbursement
```
$payload = \QuetzalStudio\Flip\Factories\MoneyTransferFactory::make([
    'account_number' => '1122333300',
    'bank_code' => 'bni',
    'amount' => '10000',
    'remark' => 'some remark',
    'recipient_city' => '391',
    'beneficiary_email' => 'test@mail.com,user@mail.com'
]);

Flip::moneyTransfer($idempotencyKey = 'KEY1000', $payload);
```

### Create Special Money Transfer / Create Special Disbursement
```
$payload = \QuetzalStudio\Flip\Factories\SpecialMoneyTransferFactory::make([
    'account_number' => '1122333301',
    'bank_code' => 'bni',
    'amount' => '10000',
    'remark' => 'some remark',
    'recipient_city' => '391',
    'sender_country' => 100252,
    'sender_place_of_birth' => 391,
    'sender_date_of_birth' => '1992-01-01',
    'sender_identity_type' => 'nat_id',
    'sender_name' => 'John Doe',
    'sender_address' => 'Some Address Street 123',
    'sender_identity_number' => '123456789',
    'sender_job' => 'entrepreneur',
    'direction' => 'DOMESTIC_SPECIAL_TRANSFER',
    'beneficiary_email' => 'test@mail.com,user@mail.com'
]);

Flip::specialMoneyTransfer($idempotencyKey = 'KEY1000', $payload);
```

## Notes
By default all API with return the actual data (int, bool, array) and will throw if request error.

### Need HTTP Response?
```
Flip::useHttpResponse();

try {
    Flip::balance(); // return Illuminate\Http\Client\Response
} catch (\Illuminate\Http\Client\RequestException $e) {
    // handle request exception
} catch (\Exception $e) {
    // handle exception
}
```

### Disable throw
```
Flip::disableThrow();

Flip::balance();
```