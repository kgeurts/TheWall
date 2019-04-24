<?php

//Hier slaan we alle fouten in op
$errors = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {

// Eerst de data opschonen 
$voornaam = filter_var($_POST['voornaam'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$achternaam = filter_var($_POST['achternaam'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
//De methode's SHA1 en MD5 zijn makkelijk te kraken en dus al gekraakt. SHA256 is ook al gekraakt maar is zelfs nu nog erg moeilijk om te kraken. Van deze 3 kun je dus het best SHA256 gebruiken.
// Salt is een extra laag met data toevoegen aan het wachtwoord zodat je gehashde string niet door een lijst te halen is
$password = password_hash($password, PASSWORD_DEFAULT);

// Genereer 32 random bytes en zet om naar hexadecimale tekst
$random_bytes = bin2hex(random_bytes(32));
 
// Genereer een hash hiervan en gebruik dit als verificatie code
$verification_code = hash('md5', $random_bytes);
if(empty($voornaam)){
    // voornaam is leeg
    $errors['voornaam'] = '<br>Uw voornaam is niet ingevuld, dit veld is verplicht.';
}

// Valideren of dit het formaat van een email-adres heeft
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    // Ongeldige email
    $errors['email'] = '<br>Uw email adres is niet juist ingevuld.';
}

if(empty($password)){
    // voornaam is leeg
    $errors['password'] = '<br>Uw wachtwoord is niet ingevuld, dit veld is verplicht.';
}

if(empty($achternaam)){
    // voornaam is leeg
    $errors['achternaam'] = '<br>Uw achternaam is niet ingevuld, dit veld is verplicht.';
}
	
}

if(isset($_POST['submit'])){
#Makeing PDO connection
$servername = "localhost";
$username = "u302406342_kevin";
$pass = "PASSWORD";
$dbname = "u302406342_kevin";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO gebruikers (voornaam, achternaam, email, password, code)
    VALUES (?, ?, ?, ?, ?)";
    // use exec() because no results are returned
    $conn->prepare($sql)->execute([$voornaam,$achternaam,$email,$password,$verification_code]);
    echo "<p class='text'>User succesvol opgeslagen in database</p>";


    // Hier gaan we de verificatie maken.
    // Pas gegevens hieronder aan met de juiste Ma-Cloud gegevens 
// en urls voor jouw 'The Wall' project
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );

$verify_link = 'http://files.kevin-geurts.nl/bewijzenmap/periode1.3/BAP/6A/verify.php?code=' . $verification_code . '&e=' . $email;

$email_to = $_POST['email'];
$email_from = 'info@kevin-geurts.nl';
$subject = 'Verificatie The Wall';

// Hier maken we een heel kort email bericht
$message = 'Beste ' . $_POST['voornaam'] . ' bedankt voor het registeren, klik op deze link om je account te bevestigen: ' . "\n" .  $verify_link ;

// Het afzender en reply-to adres moeten we in een speciale $headers array zetten
$headers = "From: ". $email_from . "\r\n";
$headers.= "Reply-To: ". $email_from . "\r\n";

$result = mail (
    $email_to,
    $subject,
    $message, 
    $headers
);

if(!$result){
   echo "<p class='text'>Er ging iets fout bij het versturen van de verificatie e-mail</p>";
   exit;
} else{
   echo "<p class='text'>Klik de link in de verificatie email om je account te bevestigen</p>";
   exit;
}
    }



catch(PDOException $e)
    {
    echo  "<br>" . $e->getMessage();
    }

$conn = null;
}
?>

<?php 

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
	<title></title>
</head>
<body>
    <div class="header">
        <h2>Register</h2>
    </div>
<form action="register.php" method="POST">

<div class="input-group">
<label>Voer voornaam in:</label>
<input type="text" name="voornaam" value="" /> <?php if (!empty($errors['voornaam'])) {
	echo $errors['voornaam'];
} ?>
</div>


<br>

<div class="input-group">
<label>Voer achternaam in:</label>
<input type="text" name="achternaam" value="">
 <?php if (!empty($errors['achternaam'])) {
	echo $errors['achternaam'];
} ?>
</div>


<br>

<div class="input-group">
<label>Voer een email in</label>
<input type="text" name="email" value="">
 <?php if (!empty($errors['email'])) {
	echo $errors['email'];
} ?>
</div>


<br>

<div class="input-group">
<label>Wat is je password?</label>
<input type="password" name="password" value="">
 <?php if (!empty($errors['password'])) {
	echo $errors['password'];
} ?>
</div>
<br>
<button type="submit" class="btn" name="submit">Stuur op</button>
<p>Al geregisteerd? <a href="login.php">Login</a></p>
</form>
</body>
</html>
