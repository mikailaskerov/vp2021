<?php
	$author_name = "Mukail Askerov";
	require_once("../../config.php");
	require_once("fnc_film.php");
	$film_store_notice = null;
	if (isset($_POST["film_submit"])){
		if (!empty($_POST["title_input"]) and !empty($_POST["year_input"]) and !empty($_POST["duration_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"])) {
			
			$film_store_notice = store_film($_POST["title_input"],$_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"]);
		} else{
			$film_store_notice = "Osa andmeid puudu!";
		}
	}
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
	<h2>Eesti filmide lisamine andmebaasi</h2>
	<form method="POST">
		<label for="title_input">Filmi pealkiri</label>
		<input type="text" name= "title_input" id="title_input" placeholder="filmi pealkiri">
		<br>
		<label for="year_input">Filmi aasta</label>
		<input type="number" name= "year_input" id="year_input" placeholder="filmi aasta" min="1912" value="1912" max="2021">
		<br>
		<label for="duration_input">Filmi kestus</label>
		<input type="number" name= "duration_input" id="duration_input" placeholder="filmi kestus" min="1" value="60" max="600">
		<br>
		<label for="genre_input">Filmi žanr</label>
		<input type="text" name= "genre_input" id="genre_input" placeholder="filmi žanr">
		<br>
		<label for="studio_input">Filmi tootja</label>
		<input type="text" name= "studio_input" id="studio_input" placeholder="filmi tootja">
		<br>
		<label for="director_input">Filmi režisöör</label>
		<input type="text" name= "director_input" id="director_input" placeholder="filmi režisöör">
		<br>
		<input type="submit" name= "film_submit" value="Salvesta">
	</form>
	<span><?php echo $film_store_notice ?></span>
</body>
</html>