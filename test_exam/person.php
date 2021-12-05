<?php
	require_once ("../../../config.php");
	require_once ("../fnc_general.php");
    require_once("fnc_party.php");
	
	$firstname = null;
	$lastname = null;
	$sid = null;
	$firstname_error = null;
	$lastname_error = null;
	$sid_error = null;
	$cancellation = null;
	$notice = null;

	if(isset($_POST["registration_submit"])){
		if(isset($_POST["firstname_input"]) and !empty($_POST["firstname_input"])){
			$firstname = test_input(filter_var($_POST["firstname_input"], FILTER_SANITIZE_STRING));
		} else {
			$firstname_error = "Palun sisesta oma eesnimi!";
		}
		
		if(isset($_POST["lastname_input"]) and !empty($_POST["lastname_input"])){
			$lastname = test_input(filter_var($_POST["lastname_input"], FILTER_SANITIZE_STRING));
		} else {
			$lastname_error = "Palun sisesta oma perekonnanimi!";
		}

		if(isset($_POST["sid_input"]) and !empty($_POST["sid_input"])){
			$sid = filter_var($_POST["sid_input"], FILTER_VALIDATE_INT);
			$numlength = strlen($sid);
			if($numlength != 6){
				$sid_error = "Teie kood on liiga lühike voi suur!";
			}
		} else {
			$sid_error = "Palun sisesta kuukohaline üliõpilaskood!";
		}

		if(empty($firstname_error) and empty($lastname_error) and empty($sid_error)){
			$notice = register($firstname, $lastname, $sid);
			$firstname = null;
			$lastname = null;
			$sid = null;
		}
		
	}
	
	if(isset($_POST["cancellation_submit"])){
		if(isset($_POST["sid"]) and !empty($_POST["sid"])){
			$sid = filter_var($_POST["sid"], FILTER_VALIDATE_INT);
			$numlength = strlen($sid);
			if($numlength != 6){
				$sid_error = "Teie kood on liiga lühike voi suur!";
			}
		} else {
			$sid_error = "Palun sisesta kuukohaline üliõpilaskood!";
		}
		
		if(empty($sid_error)){
			$cancellation = cancel($sid);
		}
	}
	
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Peol osalemise kinnitamine</title>
</head>
<body>
	<h1>Peol osalemise kinnitamine</h1>
	<p>Pane oma info:.</p>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="firstname_input">Eesnimi:</label><br>
		<input name="firstname_input" id="firstname_input" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstname_error; ?></span><br>
		<label for="lastname_input">Perekonnanimi:</label><br>
		<input name="lastname_input" id="lastname_input" type="text" value="<?php echo $lastname; ?>"><span><?php echo $lastname_error; ?></span><br>
		<label for="sid_input">Üliõpilaskood:</label><br>
		<input name="sid_input" id="sid_input" type="text" value="<?php echo $sid; ?>"><span><?php echo $sid_error; ?></span><br><br>
		<input name="registration_submit" type="submit" value="Kinnitan osalemise"><span><br>
		<br>
		<?php echo $notice; ?></span>
		
<hr>
	
	<h3>Peole tulijad</h3>
	<p>Peol osalemise on kinnitanud <?php echo count_registred(); ?> inimest.</p>
	<p>Nendest <?php echo count_paid_people(); ?> juba tasulised piletid.</p>

	<hr>
	<h3>Tühistamisvorm</h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="sid">Üliõpilaskood:</label><br>
		<input name="sid" id="sid" type="text" value="<?php echo $sid; ?>"><span><?php echo $sid_error; ?></span><br><br>
		<input type="submit" name="cancellation_submit" value="Tühistan osalemise">
		
	</form>
	<span><?php echo $cancellation; ?></span>
	

</body>
</html>