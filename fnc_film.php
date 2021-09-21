<?php
$database = "if21_mukail_as";
function read_all_films () {
	$conn = new mysqli ($GLOBALS["server_host"], $GLOBALS["server_user_name"],$GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("SELECT * FROM film");
	echo $conn->error;
	$stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db);
	$stmt->execute();
	$films_html = null;
	while ($stmt->fetch()){
	$films_html .= "<h3>" . $title_from_db . "</h3> \n";
	$films_html .= "<ul> \n";
	$films_html .= "<li> Valmistaja: " . $year_from_db . "</li> \n";
	$films_html .= "<li> Aasta: " . $duration_from_db . "</li> \n";
	$films_html .= "<li> Zaanr: " . $genre_from_db . "</li> \n";
	$films_html .= "<li> Stuudio: " . $studio_from_db . "</li> \n";
	$films_html .= "<li> Director: " . $director_from_db . "</li> \n";
	$films_html .= "</ul> \n";
	};
	$stmt->close();
	$conn->close();
	return  $films_html;
	}
	
	function store_film ($title_input,$year_input, $duration_input, $genre_input, $studio_input, $director_input) {
	$conn = new mysqli ($GLOBALS["server_host"], $GLOBALS["server_user_name"],$GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) values(?,?,?,?,?,?)");
	echo $conn->error;
	$stmt->bind_param("siisss", $title_input,$year_input, $duration_input, $genre_input, $studio_input, $director_input);
	$success = null;
	if ($stmt->execute()){
		$success = "Salvestamine õnnestus!";
	}
	else {
		$success = "Salvestamisel tekkis viga: " . $stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $success;
	};
	?>