<?php 
//Sessie starten
session_start();

 
//Controleren of er een gebruiker_id in de sessie staat
// Als dat niet zo is, de gebruiker doorsturen naar het inlog formulier.
if(empty($_SESSION['gebruiker_id'])){
  header('Location: login.php'); 
   exit();
}
if(!empty($_SESSION['gebruiker_id'])){
  echo "<p style='color: white; padding-bottom: 15px; margin-left: 5px;'>Ingelogd als: " . $_SESSION['gebruiker_naam'] ." <a href='logout.php'><button id='loguit'>Uitloggen</button></a>
 " . "</p>"; 
}

?>