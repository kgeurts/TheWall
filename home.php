<?php
require "check-login.php";
if ( isset($_POST['upload'])) {
  $target = "images/".basename($_FILES['image']['name']);

  $db = mysqli_connect("localhost", "u302406342_kevin", "Y1o232nkkguZ", "u302406342_kevin");
  
  $image = $_FILES['image']['name'];
  $text = $_POST['text'];
  $titel= $_POST['titel'];

  $sql = "INSERT INTO images (image, text, titel) VALUES ('$image', '$text', '$titel')";
  mysqli_query($db, $sql); 

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    $msg = "Image uploaded succesfully";
  }else{
    $msg = "There was a problem uploading image";
  }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Sam Harwig & Kevin Geurts"/>
    <meta name="klas" content="MD1B"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Wall</title>
    <link rel="stylesheet" type="text/css" media="screen" href="sam/home.css" />
</head>
<body>
<header>
        <br>
        <ul>
        <li><a href="soon.php">Contact</a></li>
          <li><a href="soon.php">My Account</a></li>
          <li><a href="home.php">Home</a></li>
        </ul>
          <img src="logo.png" >
          <p class="tagline"></p>
          <br>
  </header>

<div id="content">
<?php
  $db = mysqli_connect("localhost", "u302406342_kevin", "Y1o232nkkguZ", "u302406342_kevin");
    $sql = "SELECT * FROM images";
    $result = mysqli_query($db, $sql); 
    while ($row = mysqli_fetch_array($result)) {
    
      echo "<div id='img_div'>";
       echo "<h2 style='padding-bottom:20px; padding-top: 10px;'>".$row['titel']."</h2>";
        echo "<img src='images/".$row['image']."' >";
        echo "<p style='padding-bottom:20px; padding-top: 10px;'>".$row['text']."</p>";
      echo "</div>";
    }

?>
    <form id="form" method="post" action="home.php" enctype="multipart/form-data">
    <input type="hidden" name="size" value="1000000">
    <div>
       <input id="input" type="file" name="image">
    </div>
    <div>
      <textarea id="invul" name="titel" cols="40" rowns="4" placeholder="Titel van de afbeelding hier..."></textarea>
       <textarea id="invul" name="text" cols="40" rowns="4" placeholder="Beschrijving van de afbeelding hier..."></textarea>
       </div>
      <input id="upload" type="submit" name="upload" value="Upload Image">
    </div>
    </div>
    </form>
  </div> 
 </div>
 <footer>
        <br>
        <p>Copyright © 2019 Sam Harwig & Kevin Geurts</p>
        <p></p>
        <p class="tagline"></p>
        <br>
  </footer>   
</body>
</html>