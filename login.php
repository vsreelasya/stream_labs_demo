<?php
if(isset($_SESSION))
    session_destroy();
session_start();

$client_id = getenv('CLIENT_ID');
$redirect_uri = getenv('REDIRECT_URI');
$scope= "user:read:broadcast";

$twitchLogin_url = "https://id.twitch.tv/oauth2/authorize"
    ."?client_id={$client_id}"
    ."&response_type=code"
    ."&redirect_uri={$redirect_uri}"
    ."&scope={$scope}";
    
    header("Location: ".$twitchLogin_url, true, 301); 
echo "URL";