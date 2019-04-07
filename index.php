<?php 
if(isset($_SESSION))
    session_destroy();
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Streamlabs_demo</title>
</head>
<body>
<form id="twicthlogin" action="login.php" method="post">
<input type="submit" value="Twitch Login"/>
</form>

</body>
</html>