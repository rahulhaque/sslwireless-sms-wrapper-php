# SslWireless Sms Api Wrapper for PHP / Laravel
A simple php wrapper for sslwireless sms api. Supports Laravel.

## Usage
- Clone the repository.
- Require the class and create instance to access its functions.
- Or install with `composer require sslwireless/sslwireless-sms`

## Example
```php
<?php

require 'src/SslWirelessSms.php';
use SslWireless\SslWirelessSms;

// username, password, sid provided by sslwireless
$SslWirelessSms = new SslWirelessSms('username','password', 'sid');
// You can change the api url if needed. i.e.
// $SslWirelessSms->setUrl('new_url');
$output = $SslWirelessSms->send('123456789','This is a test message.');

print_r($output);

?>
```

## Laravel
- Install with `composer require sslwireless/sslwireless-sms`
```php
<?php

use SslWireless\SslWirelessSms; // Use the installed package

class SomeController extends Controller
{
    public function someFunction()
    {
        // username, password, sid provided by sslwireless
        $SslWirelessSms = new SslWirelessSms('username','password', 'sid');
        // You can change the api url if needed. i.e.
        // $SslWirelessSms->setUrl('new_url');
        $output = $SslWirelessSms->send('123456789','This is a test message.');

        dd($output);
    }
}

?>
```

## Output
The output will always be in JSON format.
```javascript
{
  "status": "success", // or "failed"
  "result": "sms sent", // or "invalid mobile or text" or "invalid mobile" or "invalid credentials"
  "phone": "123456789", // number to send message
  "message": "This is a test message.", // message sent
  "reference_no": "randomly_generated_unique_no", // client generated reference no
  "ssl_reference_no": "returned_sslwirless_reference_no", // api generated reference no
  "datetime": "2018-02-07 01:35AM" // datetime of process
}
```
