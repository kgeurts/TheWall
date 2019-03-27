<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Titel hier</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
	<h2>Register</h2>
</div>
<form method="post" action="register.php">
	<?php echo display_error(); ?>
	<div class="input-group">
		<label>Gebruikersnaam</label>
		<input type="text" name="username" value="<?php echo $username; ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Nogmaals uw password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn">Registeer</button>
	</div>
	
	<p>
		Al registeerd? <a href="login.php">Log in</a>
	</p>
</form>
</body>
</html>