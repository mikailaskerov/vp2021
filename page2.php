<?php
	$author_name = "Mukail Askerov";
	$todays_evaluation = null;
	$inserted_adjective = null;
	$adjective_error = null;
	
	if(isset($_POST["todays_adjective_input"])){

		if(!empty($_POST["adjective_input"])){
			$todays_evaluation = "<p>Tanane paev on <strong>" .$_POST["adjective_input"] ."</strong>.</p><hr>";
			$inserted_adjective = $_POST["adjective_input"];
		} else {
			$adjective_error = "Palun kirjuta tanase paeva kohta sobiv omadussona!";
		}
	}
	
	$photo_dir = "photos/";
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$all_files = array_slice(scandir($photo_dir), 2);
	$photo_files = [];
	foreach($all_files as $file){
		$file_info = getimagesize($photo_dir .$file);
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push($photo_files, $file);
			}
		}
	}
	array_unshift ($photo_files,"Valitamata");
	$limit = count($photo_files);
	$pic_num = mt_rand(1, $limit - 1);
	$pic_file = $photo_files[$pic_num];
	$list_html = "<ul> \n";
	for($i = 1; $i < $limit; $i ++){
		$list_html .= "<li>" .$photo_files[$i] ."</li> \n";
	}
	$list_html .= "</ul>";
	$photo_select_html = '<select name="photo_select">' ."\n";
	for($i = 0; $i < $limit; $i ++){
		$photo_select_html .= '<option value="' .$i .'">' .$photo_files[$i] ."</option> \n";
	}
	$photo_select_html .= "</select> \n";
	if(isset($_POST["valik"])){
		if(!empty($_POST["photo_select"])){
			$valikud=$_POST["photo_select"];
			$pic_file=$photo_files[$valikud];
		}
	}
	$pic_html = '<img src="' .$photo_dir .$pic_file .'" alt="Tallinna Ulikool">';
?><!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title> <?php echo $author_name; ?>, Veebiprogrammeerimine</title>
</head>
<body
style="background: rgb(2,0,36); background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(139,139,167,1) 44%, rgba(43,100,173,1) 86%)";>
<center>
		<h1><?php echo $author_name;?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud oppetoo raames ja ei sisalda mingisugust tosiseltvoetavat sisu!</p>
	<p>Oppetoo toimus <a href="https://www.tlu.ee/dt">Tallinna Ulikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
	<form method="POST">
		<input type="text" name="adjective_input" placeholder="omadussona tanase kohta" value="<?php echo $inserted_adjective; ?>">
		<input type="submit" name="todays_adjective_input" value="Saada ara">
		<span><?php echo $adjective_error; ?></span>
	</form>
	<hr>
	<?php echo $todays_evaluation;?>
	<form method="POST"><?php echo $photo_select_html; ?>
	<input type="submit" name="valik" value="Vali pilt">
	</form>
	<?php
	echo $pic_html;
	echo "<hr> \n";
	echo $pic_file . "<br>";
	echo "<hr> \n";
	echo $list_html;
	?>
</center>
</body>
</html>
