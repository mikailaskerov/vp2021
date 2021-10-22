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
	
	require_once("fnc_general.php");
	require_once("fnc_info.php");
	require_once("../../config.php");
	$birth_month = null;
    $birth_year = null;
    $birth_day = null;
    $birth_date = null;
    $month_names_et = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
	
	$movie_save_notice = null;
	$genre_save_notice = null;
	$position_save_notice = null;
	$person_save_notice= null;
	$year_input = date("Y");
	$birth_month_error = null;
    $birth_year_error = null;
    $birth_day_error = null;
    $birth_date_error = null;
	

	if(isset($_POST["movie_submit"])) {
			$movie_save_notice = save_movie($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["description_input"]);
	}

	if(isset($_POST["genre_submit"])) {
			$genre_save_notice = save_genre($_POST["genre_input"], $_POST["genre_description_input"]);
	}

	if(isset($_POST["position_submit"])) {
			$position_save_notice = save_position($_POST["position_input"], $_POST["position_description_input"]);
	}
	
	            //kuupäeva sisestuse kontroll
            if(isset($_POST["birth_day_input"]) and !empty($_POST["birth_day_input"])){
                $birth_day = filter_var($_POST["birth_day_input"], FILTER_VALIDATE_INT);
                if($birth_day < 1 or $birth_day > 31){
                    $birth_day_error = "Palun vali sünni päev!";
                }
            } else {
                $birth_day_error = "Palun vali sünni päev!";
            }
            
            if(isset($_POST["birth_month_input"]) and !empty($_POST["birth_month_input"])){
                $birth_month = filter_var($_POST["birth_month_input"], FILTER_VALIDATE_INT);
                if($birth_month < 1 or $birth_month > 12){
                    $birth_month_error = "Palun vali sünni kuu!";
                }
            } else {
                $birth_month_error = "Palun vali sünni kuu!";
            }
            
            if(isset($_POST["birth_year_input"]) and !empty($_POST["birth_year_input"])){
                $birth_year = filter_var($_POST["birth_year_input"], FILTER_VALIDATE_INT);
                if($birth_year < date("Y") - 110 or $birth_year > date("Y") - 13){
                    $birth_year_error = "Palun vali sünni aasta!";
                }
            } else {
                $birth_year_error = "Palun vali sünni aasta!";
            }
            
            //valideerime kuupäeva ja paneme selle kokku
            if(empty($birth_day_error) and empty($birth_month_error) and empty($birth_year_error)){
                if(checkdate($birth_month, $birth_day, $birth_year)){
                    //moodustame kuupäeva
                    $temp_date = new DateTime($birth_year ."-" .$birth_month ."-" .$birth_day);
                    $birth_date = $temp_date->format("Y-m-d"); 
                } else {
                    $birth_date_error = "Valitud kuupäev on vigane!";
                }
            }  
	if(isset($_POST["person_submit"])) {
		if(checkdate($birth_month, $birth_day, $birth_year)){
		//moodustame kuupäeva
		$temp_date = new DateTime($birth_year ."-" .$birth_month ."-" .$birth_day);
		$birth_date = $temp_date->format("Y-m-d"); 
		} else {
		$birth_date_error = "Valitud kuupäev on vigane!";
		}
		$person_save_notice = save_person($_POST["first_name_input"], $_POST["last_name_input"], $birth_date);
	}
	require_once("page_header.php");
?>

		<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
		<div>
			<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
		</div>
		<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
		<h2>Info lisamine andmebaasi</h2>
		<hr>
		<h3>Film:</h3>
		<form method ="POST">
			<label for="title_input">Filmi pealkiri</label>
			<input type="text" name="title_input" id="title_input">
			<label for="year_input">Valmimisaasta</label>
			<input type="number" name="year_input" id="year_input" min="1912" value="<?php echo $year_input; ?>" max="<?php echo $year_input; ?>">
			<label for="duration_input">Kestus</label>
			<input type="number" name="duration_input" id="duration_input" min="1" value="80" max="3600">
			<br>
			<label for="description_input">Filmi lühikirjeldus</label>
			<br>
			<textarea name="description_input" id="description_input" rows="10" cols="90" placeholder="Täitke nõutav teave"></textarea>
			<br>
			<input type="submit" name="movie_submit" value="Salvesta">
		</form>
		<span><?php echo $movie_save_notice; ?></span>
		<hr>
		<h3>Zanr:</h3>
		<form method ="POST">
			<label for="genre_input">Zanri nimetus:</label>
			<input type="text" name="genre_input" id="genre_input">
			<br>
			<label for="genre_description_input">Zanri lühikirjeldus:</label>
			<br>
			<textarea name="genre_description_input" id="genre_description_input" rows="3" cols="90" placeholder="Täitke nõutav teave"></textarea>
			<br>
			<input type="submit" name="genre_submit" value="Salvesta">
		</form>
		<span><?php echo $genre_save_notice; ?></span>
		<hr>
		<h3>Isik:</h3>
		<form method ="POST">
			<label for="first_name_input">Eesnimi:</label>
			<input type="text" name="first_name_input" id="first_name_input">
			<br>
			<label for="last_name_input">Perekonnanimi:</label>
			<input type="text" name="last_name_input" id="last_name_input">
			<br>
			<label for="birth_day_input">Sünnikuupäev: </label>
		  <?php
			//sünnikuupäev
			echo '<select name="birth_day_input" id="birth_day_input">' ."\n";
			echo "\t \t" .'<option value="" selected disabled>päev</option>' ."\n";
			for($i = 1; $i < 32; $i ++){
				echo "\t \t" .'<option value="' .$i .'"';
				if($i == $birth_day){
					echo " selected";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "\t </select> \n";
		  ?>
			  <label for="birth_month_input">Sünnikuu: </label>
		  <?php
			echo '<select name="birth_month_input" id="birth_month_input">' ."\n";
			echo "\t \t" .'<option value="" selected disabled>kuu</option>' ."\n";
			for ($i = 1; $i < 13; $i ++){
				echo "\t \t" .'<option value="' .$i .'"';
				if ($i == $birth_month){
					echo " selected ";
				}
				echo ">" .$month_names_et[$i - 1] ."</option> \n";
			}
			echo "</select> \n";
		  ?>
		  <label for="birth_year_input">Sünniaasta: </label>
		  <?php
			echo '<select name="birth_year_input" id="birth_year_input">' ."\n";
			echo "\t \t" .'<option value="" selected disabled>aasta</option>' ."\n";
			for ($i = date("Y") - 1; $i >= date("Y") - 140; $i --){
				echo "\t \t" .'<option value="' .$i .'"';
				if ($i == $birth_year){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>

		  <br>
		<input type="submit" name="person_submit" value="Salvesta">
			</form>
		<span><?php echo $person_save_notice; ?></span>
		<hr>
		<h3>Amet:</h3>
		<form method ="POST">
			<label for="position_input">Ameti nimetus:</label>
			<input type="text" name="position_input" id="position_input">
			<br>
			<label for="position_description_input">Ameti lühikirjeldus:</label>
			<br>
			<textarea name="position_description_input" id="position_description_input" rows="3" cols="90" placeholder="Täitke nõutav teave"></textarea>
			<br>
			<input type="submit" name="position_submit" value="Salvesta">
		</form>
		<span><?php echo $position_save_notice; ?></span>
		<hr>
		<ul>
		<li><a href="home.php">Avaleht</a></li>
		<li><a href="?logout=1">Logi välja</a></li>
		</ul>
	</body>
</html> 