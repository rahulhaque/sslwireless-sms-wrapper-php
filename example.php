<?php

require 'src/SslWirelessSms.php';
use SslWireless\SslWirelessSms;

// username, password, sid provided by sslwireless
$SslWirelessSms = new SslWirelessSms('username','password', 'sid');
// You can change the api url if needed. i.e.
// $SslWirelessSms->setUrl('new_url');
$result = $SslWirelessSms->send('123456789','This is a test message.');

print_r($result);

?>