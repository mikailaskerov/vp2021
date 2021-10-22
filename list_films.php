<?php
    //alustame sessiooni
    session_start();
    //kas on sisselogitud
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }; 
	
	require_once("../../config.php");
	require_once("fnc_film.php");
	$films_html = []; 
	$films_html = read_all_films();
	require("page_header.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud oppetoo raames ja ei sisalda mingisugust tosiseltvoetavat sisu!</p>
	<p>Oppetoo toimus <a href="https://www.tlu.ee/dt">Tallinna Ulikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<h2>Eesti filmid</h2>
	<?php
	for($i=0;$i<=count($films_html[0])-1;$i++){
		echo "<hr>";
		echo "<b>Pealkiri:</b> ".$films_html[0][$i]."<br>";
		echo "<b>Aasta:</b> ".$films_html[1][$i]."<br>";
		echo "<b>Pikkus:</b>" .to_hours($films_html[2][$i]) ."<br>";
		echo "<b>Kirjeldus:</b> ".$films_html[3][$i]."<br>";
		echo "<b>Žanr:</b> ".$films_html[4][$i]."<br>";
	};
	?>
	<hr>
    <ul>
        <li><a href="home.php">Avaleht</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
    </ul>
	<hr>
</body>
</html>