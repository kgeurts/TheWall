<?php 
$_GET['e'];
$_GET['code'];

// In de superglobal $_GET zitten alle parameters in de url
$code = filter_var($_GET['code'], FILTER_SANITIZE_STRING);
$email = filter_var($_GET['e'], FILTER_VALIDATE_EMAIL);
 
//Als er gegevens missen dan stoppen we met een foutmelding 
if(empty($code) || empty($email)){
    echo 'Ongeldige gegevens!'; 
    exit(); 
}
$servername = "localhost";
$username = "u302406342_kevin";
$pass = "Y1o232nkkguZ";
$dbname = "u302406342_kevin";
try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// We selecteren alle rijen in de gebruikers table die overeenkomen
// Dit doen we met een prepared statement
$sql = 'SELECT * FROM gebruikers WHERE code = ? AND email = ?';
$statement = $conn->prepare($sql);

// Een array met voor elk vraagteken in de query een waarde
$data = [
    $code,
    $email
];
$result = $statement->execute($data);

if(!$result){
    echo "<p class='text'>Fout bij ophalen van gegevens</p>";
    exit();
}

// Haal het eerste resultaat op (de gevonden gebruiker)
$gebruiker = $statement->fetch();

// Als $gebruiker leeg is, dan is de link ongeldig OF al gebruikt
if(empty($gebruiker)){
    echo "<p class='text'>Ongeldige verificatie link of al gebruikte link</p>";
    exit();
}

// Als we tot hier komen is er dus een rij gevonden in de database!
// Nu kunnen we de verificatie code leegmaken en een melding tonen 
$gebruikers_id = $gebruiker['id'];
$sql = 'UPDATE gebruikers SET code = "" WHERE id = ?';
$statement = $conn->prepare($sql);

// Op de plek van het vraagteken in de query komt de id van de gebruiker
$data = [
    $gebruikers_id
];
$result = $statement->execute($data);

if(!$result){
    echo "<p class='text'>Er ging iets fout bij het opslaan van de gegevens</p>";
    exit();
}
}
catch(PDOException $e)
    {
    echo  "<br>" . $e->getMessage();
    }
    $conn = null;
    echo "<p class='text'>Verificatie gelukt, je kunt nu <a href='login.php'>inloggen</a>.</p>";
?>