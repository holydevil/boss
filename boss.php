<?php
require("OAuth.php");

//setup variables
$cc_key  = "consumer key";
$cc_secret = "consumer secret";
//$url = "http://yboss.yahooapis.com/ysearch/news,web,images"; // uncomment this line for doing web, news and images in one single query
$url = "http://yboss.yahooapis.com/ysearch/web";
$args = array();
$args["q"] = isset($_GET["q"]) ? $_GET["q"] : "yahoo";	//pass parmeter as ?q=<param> in the URL
$args["format"] = "json";   //or xml

//OAuth stuff
$consumer = new OAuthConsumer($cc_key, $cc_secret);
$request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
$url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));

//cURL stuff
$ch = curl_init();
$headers = array($request->to_header());
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$srp = curl_exec($ch);

//results
$results = json_decode($srp);

echo "<pre>";
print_r($results);
echo "</pre>";
?>
