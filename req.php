<?php

function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function pars($params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }
    return "?".implode('&', $r);
}

function buildAuthorizationHeader($oauth) {
    $rx = "";
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $rx = 'Authorization: OAuth '.implode(',', $values);
    return $rx;
}

// $dowhat=$_GET["d"];

if ($_GET["trends"]=="place") {
$url = "https://api.twitter.com/1.1/trends/place.json";
$extpar = array('id' => '1');
}
else if (isset($_GET["trends"])) {
$url = "https://api.twitter.com/1.1/trends/place.json";
$extpar = array('id' => $_GET["trends"]);
}
else if ($_GET["app"]=="limit") {
$url = "https://api.twitter.com/1.1/application/rate_limit_status.json";
$extpar = array('resources' => 'trends');
}
else if (isset($_GET["trendsclosest"])) {
$url = "https://api.twitter.com/1.1/trends/closest.json";
$dataa=explode(',', $_GET["trendsclosest"]);
$extpar = array('lat' => $dataa[0], 'long' => $dataa[1]);
}
else {
$url = "https://api.twitter.com/1.1/trends/place.json";
$extpar = array('id' => '1');
}

$oauth_access_token = "YOUR TOKEN";
$oauth_access_token_secret = "TOKEN SECRET";
$consumer_key = "CONSUMER KEY";
$consumer_secret = "CONSUMER SECRET";

$oauth = array('oauth_consumer_key' => $consumer_key,
                'oauth_nonce' => time()*sha1(microtime(true).mt_rand(10000,90000)),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_timestamp' => time(),
                'oauth_token' => $oauth_access_token,
                'oauth_version' => '1.0');

$base_info = buildBaseString($url, 'GET', array_merge($oauth, $extpar));
$composite_key = $consumer_secret . '&' . $oauth_access_token_secret;
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

// Make Requests
$header = array(buildAuthorizationHeader($oauth), 'Expect:');
$options = array(CURLOPT_HTTPHEADER => $header,
                  // CURLOPT_POSTFIELDS => $postfields,
                  CURLOPT_HEADER => false,
                  CURLOPT_URL => $url . pars($extpar),
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_SSL_VERIFYPEER => false);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

//echo var_dump($header)."<br /><br />";
//echo var_dump($base_info)."<br /><br />";
//echo var_dump($composite_key)."<br /><br />";
echo $json;

?>  		
