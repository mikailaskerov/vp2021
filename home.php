<?php
    //alustame sessiooni
    session_start();
	require ("fnc_user.php");
	require ("page_header.php");
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
    
		<li><a href="list_films.php">Filmide tabel</a></li>
		<li><a href="add_films.php">Filmide lisamine andmebaasi</a></li>
		<li><a href="add_info.php">Info lisamine andmebaasi</a></li>
		<li><a href="movie_relations.php">Filmi info sidumine</a></li>
		<li><a href="list_movie_info.php">Filmi info tabel</a></li>
		<li><a href="gallery_photo_upload.php">Fotode uleslaadimine</a></li>
		<li><a href="user_profile.php">Minu konto</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
    </ul>

</body>
</html> 