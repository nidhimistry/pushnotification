
<?php
	//$push_type = "alert";
    $deviceToken = $deviceToken;
    $payload = array();
    $payloadArr = array('sound' => 'default','alert' => $message,'push_type'=>$push_type,'title' => $subject,'message'=> $message);
    $payload['aps'] =$payloadArr;
	$payload = json_encode($payload);
    //$apnsHost = 'gateway.sandbox.push.apple.com'; // for development
    $apnsHost = 'gateway.push.apple.com'; //for production
    $apnsPort = 2195;
    $apnsCert = 'pushcertCooltec.pem'; //path to applications pem certificate
    $passphrase = '12345';
    $streamContext = @stream_context_create();
    @stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    @stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
    // echo "connection openend";
    // die;
    //$apns = @stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
    $apns = @stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
    $apnsMessage = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    @fwrite($apns, $apnsMessage);
    if($apns)
    {
        // echo "push sent successfully.";die();
    }
    else
    {
        // echo "Error..! push not sent successfully.";die();
    }

?>