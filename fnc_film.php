<?php
$database = "if21_mukail_as";

function read_all_films(){
		//var_dump($GLOBALS);
        //avan andmebaasiühenduse      server, kasutaja, parool, andmebaas
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		//määrame vajaliku kodeeringu
		$conn->set_charset("utf8");
		$stmt=$conn->prepare("SELECT movie.title,movie.production_year,movie.duration,movie.description,genre.genre_name FROM movie JOIN movie_genre ON movie.id=movie_genre.movie_id JOIN genre ON movie_genre.genre_id=genre.id");
        //igaks juhuks, kui on vigu, väljastame need
        echo $conn->error;
        //seome tulemused muutujatega
		$stmt->bind_result($title,$year,$duration,$description,$genre);
		$stmt->execute();
		$atitle=[];
		$ayear=[];
		$aduration=[];
		$adescription=[];
		$agenre=[];
		while($stmt->fetch())
			{
				array_push($atitle, $title);
				array_push($ayear, $year);
				array_push($aduration, $duration);
				array_push($adescription, $description);
				array_push($agenre, $genre);
			}
		$stmt->close();
		$conn->close();
		$arr=[$atitle, $ayear, $aduration, $adescription, $agenre];
		return $arr;
	}

    function store_film($title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input){
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) values(?,?,?,?,?,?)");
        echo $conn->error;
        //seon SQL käsu päris andmetega, andmetüübid :i - integer, d - decimal, s - string
        $stmt->bind_param("siisss", $title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input);
        $success = null;
        if($stmt->execute()){
            $success = "Salvestamine õnnestus!";
        } else {
            $success = "Salvestamisel tekkis viga: " .$stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $success;
    }
;
function to_hours($time)
{
	$hours = $time/60;
	$min = null;
	if($hours<1){
		$total=$time.'min';
	}else{
		$hours = floor (($time-$min)/60);
		$min = $time%60;
		$total = $hours ." h " .$min ." min ";
	}
	return $total;
}
	?>