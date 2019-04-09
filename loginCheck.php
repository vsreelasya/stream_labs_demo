<?php
session_start();
$client_id = getenv('CLIENT_ID');
$clientSecret = getenv('CLIENT_SECRET');
$redirect_uri = getenv('REDIRECT_URI');

if ($_GET['code']) {
    $_SESSION['code'] = $_GET['code'];
    $_SESSION['scope'] = $_GET['scope'];
    $token_url = "https://id.twitch.tv/oauth2/token" . "?client_id={$client_id}" . "&client_secret={$clientSecret}" . "&code={$_GET['code']}" . "&grant_type=authorization_code" . "&redirect_uri={$redirect_uri}";
    $curl = curl_init($token_url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $resCurl = curl_exec($curl);
    curl_close($curl);
    if ($resCurl) {
        $res = json_decode($resCurl);
        $_SESSION['token'] = $res->access_token;
    }

?>

<html>
<head>
<title>Home</title>
<script type="text/javascript">
 function myFunction() {
	 var x = document.getElementById("streamer_name").value;
	 window.location.href = "https://salty-river-25659.herokuapp.com/homePage.php?streamer="+x;
 }
</script>
</head>
<body>
	<div style="float: left; margin-right: 15px">
		Streamer name: <input type="text" id="streamer_name">
		<button onclick="myFunction()">Find</button>
	</div>
</body>
</html>
<?php
} else {

    header("Location: /errorPage.php", true, 301);
}
?>



