<?php

namespace SslWireless;

class SslWirelessSms
{

    private $user, $password, $sid, $url = 'http://sms.sslwireless.com/pushapi/dynamic/server.php';

    /**
     * Get default api url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set default api url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Set default authentication parameters
     *
     * SslWirelessSms constructor.
     * @param $username
     * @param $password
     * @param $sid
     */
    function __construct($username, $password, $sid)
    {
        $this->user = $username;
        $this->password = $password;
        $this->sid = $sid;
    }

    /**
     * Send the message to desired number
     *
     * @param $phone
     * @param $message
     * @return string
     */
    function send($phone, $message)
    {
        $url = $this->url;
        $data = [
            'user' => $this->user,
            'pass' => $this->password,
            'sms[0][0]' => $phone,
            'sms[0][1]' => $message,
            'sms[0][2]' => random_int(1, 99999999),
            'sid' => $this->sid
        ];

        // key 'http' is same for both http and https
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $parsed_result = simplexml_load_string($result);

        if ($parsed_result->SMSINFO->REFERENCEID) {

            return json_decode(json_encode([
                'status' => 'success',
                'result' => 'sms sent',
                'phone' => $phone,
                'message' => $message,
                'reference_no' => $parsed_result->SMSINFO->CSMSID,
                'ssl_reference_no' => $parsed_result->SMSINFO->REFERENCEID,
                'datetime' => date('Y-m-d H:ia')
            ]));

        }
        elseif ($parsed_result->SMSINFO->SMSVALUE) {

            return json_decode(json_encode([
                'status' => 'failed',
                'result' => 'invalid mobile or text',
                'phone' => $phone,
                'message' => $message,
                'reference_no' => '',
                'ssl_reference_no' => '',
                'datetime' => date('Y-m-d H:ia')
            ]));

        }
        elseif ($parsed_result->SMSINFO->MSISDNSTATUS) {

            return json_decode(json_encode([
                'status' => 'failed',
                'result' => 'invalid mobile no',
                'phone' => $phone,
                'message' => $message,
                'reference_no' => '',
                'ssl_reference_no' => '',
                'datetime' => date('Y-m-d H:ia')
            ]));

        }
        else {

            return json_decode(json_encode([
                'status' => 'failed',
                'result' => 'invalid credentials',
                'phone' => $phone,
                'message' => $message,
                'reference_no' => '',
                'ssl_reference_no' => '',
                'datetime' => date('Y-m-d H:ia')
            ]));

        }

    }

}