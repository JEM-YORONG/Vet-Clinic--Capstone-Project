<?php
// forgot password
function sendPass($username, $email, $pass)
{
    try {
        $accountSid = '';
        $authToken = '';

        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $accountSid . '/Messages.json';

        $message = "Important Account Information
    
    Hello {$username},
    
    We hope you're having a great day! As a friendly reminder, here is your account information:
    
    Email: {$email}
    Password: {$pass}
    
    Please be mindful to keep your password secure. If you ever forget it, you can use our \"Forgot Password\" feature on the login page to reset it.
    
    Have a wonderful day!
    
    Best regards,
    Doc Lenon Vet Clinic
    ";

        $filtered = "-------------------------------------------------------------------------------------------------------------------" . $message;

        $body = http_build_query(array(
            'To' => '+639694903757',
            'From' => '+12055828437',
            'Body' => $filtered
        ));

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Authorization: Basic " . base64_encode("$accountSid:$authToken"),
                'method' => 'POST',
                'content' => $body
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            throw new Exception('Failed to send SMS.');
        } else {
            $data = json_decode($result, true);
            print_r($data);
        }
    } catch (Exception $e) {
        //echo 'Error: ' . $e->getMessage();
    }
}
