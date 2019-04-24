<?php 
session_start();
   if($_SERVER["REQUEST_METHOD"] == "POST") { 
   	if(isset($_POST['submit'])){
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
#Makeing PDO connection
$servername = "localhost";
$username = "u302406342_kevin";
$pass = "PASSWORD";
$dbname = "u302406342_kevin";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Hier gaan we de input valideren
    $sql = "SELECT * FROM `gebruikers` WHERE email = ? ";

    $statement = $conn->prepare($sql);

    $data = [$email];
    $result = $statement->execute($data);
    if(!$result){
    	echo "<br><p class='text'>fout bij login query <a href='login.php'>Ga terug naar de login!</a></p>";
    	exit;
    }

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if(empty($user)){
    	echo "<br><p class='text'>gebruiker niet gevonden <a href='login.php'>Ga terug naar de login!</a></p>";
    	exit;
    }

    if(!password_verify($password, $user['password'])){
    	echo "<br><p class='text'>Wachtwoord fout <a href='login.php'>Ga terug naar de login!</a></p>";
    	exit;
    }

// In dit voorbeeld is $gebruiker de juiste rij die je hebt opgehaald uit de database
//debug
$_SESSION['gebruiker_id'] = $user['id'];
$_SESSION['gebruiker_naam'] = $user['voornaam'];
// Nu kun je op andere pagina's deze info opvragen
    echo "<br><p class='text'>Inloggen gelukt!</p>";
    header( "Refresh:2; url=home.php");

    }
catch(PDOException $e)
    {
    echo  "<br>" . $e->getMessage();
    }

$conn = null;
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
        <div class="header">
        <h2>Login</h2>
        </div>
<form method="POST" action="">
    <div class="input-group">
	<label name="mail_label">Email:</label>
	<input type="text" name="email">
    </div>

    <div class="input-group">
	<label name="password_label">Wachtwoord:</label>
	<input type="password" name="password">
    </div>
	<br>
<button type="submit" class="btn" name="submit">Stuur op</button>
<p> Nog niet geregisteerd? <a href="register.php">Registreer</a> </p>
</form>
</body>
</html>
