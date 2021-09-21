<?php
	$author_name = "Mukail Askerov";
	require_once("../../config.php");
	require_once("fnc_film.php");
	$films_html = null; 
	$films_html = read_all_films();
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title> <?php echo $author_name; ?>, Veebiprogrammeerimine</title>
</head>
<body style="background: linear-gradient(90deg, rgba(250,250,250,1) 48%, rgba(168,168,158,1) 70%, rgba(0,0,0,1) 100%)";>
	<h1><?php echo $author_name;?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud oppetoo raames ja ei sisalda mingisugust tosiseltvoetavat sisu!</p>
	<p>Oppetoo toimus <a href="https://www.tlu.ee/dt">Tallinna Ulikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<h2>Eesti filmid</h2>
	<?php echo $films_html; ?>
</body>
</html>