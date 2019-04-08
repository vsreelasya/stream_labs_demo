<?php
session_start();
?>
<div>
<a href="login.php" ><i>Find other streamer</i></a>
</div>
<div>
	<div id="twitch-embed"></div>

	<!-- Load the Twitch embed script -->
	<script src="https://embed.twitch.tv/embed/v1.js"></script>

	<!-- Create a Twitch.Embed object that will render within the "twitch-embed" root element. -->
	<script type="text/javascript">
      var x = "<?php echo $_GET['streamer'] ?>"
      new Twitch.Embed("twitch-embed", {
        width: 854,
        height: 480,
        channel: x
      });
        </script>
</div>

<?php
$userId_url = 'https://api.twitch.tv/helix/users?login=' . $_GET['streamer'];
$curl = curl_init($userId_url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $_SESSION['token']
));

$resCurl = curl_exec($curl);
curl_close($curl);
//echo $resCurl;
$resToken = json_decode($resCurl);
if (! empty($resToken->data)) {
    $target_user_id = $resToken->data[0]->id;
    // ======Web Hook=======
    $client_id = "sgttgmxx9y9evwlipkkh9nqzdd0zxt";
    $mode = "subscribe";
    $callback_url = "https://salty-river-25659.herokuapp.com/homePage.php";
    $lease_days = "10";
    $lease_seconds = $lease_days * 24 * 60 * 60;

    $subscribe_to_event_url = "https://api.twitch.tv/helix/webhooks/hub";

    $data = array(
        'hub.mode' => $mode,
        'hub.topic' => "https://api.twitch.tv/helix/streams?user_id=" . $target_user_id,
        'hub.callback' => $callback_url,
        'hub.lease_seconds' => $lease_seconds
    );
    $data_string = json_encode($data);

    $ch = curl_init($subscribe_to_event_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string),
        'Client-ID: ' . $client_id
    ));

    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    //echo $httpcode . "" . $result;
    if($httpcode == 202) {
        echo "<br><h1>Most Recent Events</h1>";
        if($result) {
            if ($_GET['hub.challege']) {
                echo $_GET['hub.challege'];
            }
            
        } else {
            echo "<i>No updates</i>";
        }
    }
    
}

// ======End Hook=======

?>


