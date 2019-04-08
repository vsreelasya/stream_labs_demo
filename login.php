<?php
if(isset($_SESSION))
    session_destroy();
session_start();

$client_id = "sgttgmxx9y9evwlipkkh9nqzdd0zxt";
//$clientSecret = "y84r5jiro4w20wmcra1ewfi333yo1t";
$redirect_uri = "https://salty-river-25659.herokuapp.com/streamlabs_demo/loginCheck.php";
//$response_type= "token";
$scope= "user:read:broadcast";
echo "About to hit URL";
$twitchLogin_url = "https://id.twitch.tv/oauth2/authorize"
    ."?client_id={$client_id}"
    ."&response_type=code"
    ."&redirect_uri={$redirect_uri}"
    ."&scope={$scope}";
    
    header("Location: ".$twitchLogin_url, true, 301); 
echo "URL";