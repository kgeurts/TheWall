
<?php
//Sessie starten en meteen vernietigen
session_start();
session_destroy();

// Doorsturen naar login form
header('Location: login.php');
exit;
?>