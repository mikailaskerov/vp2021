<?php
$author_name = "Mukail Askerov";
$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$full_time_now = date ("d.m.Y H:i:s");
$hour_now = date ("H");
$weekday_now = date ("N");
$day_category = "puhkpäev";
$aeg = "uneaeg";
if ($hour_now >=8 and $hour_now <23){
	$aeg = "vaba aeg";
}
if ($weekday_now <= 5){
	$day_category = "koolipäev";
	if ($hour_now >=8 and $hour_now <=18) {
		$aeg = "tundide aeg";
	}
}
$photo_dir = "photos/";
$allowed_photo_types = ["image/jpeg", "image/png"];
$all_files =  array_slice (scandir ($photo_dir), 2);
//$only_files = array_slice ($all_files, 2);
$photo_files = [];
foreach ($all_files as $file) {
	$file_info = getimagesize ($photo_dir . $file);
	if (isset($file_info ["mime"])) {
			if( in_array($file_info ["mime"], $allowed_photo_types)) {
				array_push ($photo_files, $file);
			}
	}
}
$limit = count($all_files);
$pic_num = mt_rand (0,$limit - 1);
$pic_file = $all_files[$pic_num];
$pic_html = '<img src="' . $photo_dir . $pic_file . '" alt="Tallinna Ülikool">';
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title> <?php echo $author_name; ?>, Veebiprogrammeerimine</title>
</head>
<body
style="background: rgb(2,0,36); background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(139,139,167,1) 44%, rgba(43,100,173,1) 86%)";>
<center>
	<h1> <?php echo $author_name; ?>, Veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiselvõetavat sisu!</p>
	<p>Õpetöö toimus <a href="https://www.tlu.ee/en/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<img src="logo.png" alt="Tallinna instituudi logo" width="600">
	<h2>Lehe avamise hetk: <span><?php echo  $weekday_names_et[$weekday_now - 1] . ", " . $full_time_now . ", on " . $day_category . ", " . $aeg?></span></h2>
	<h2>Kursusel õpime</h2>
	<ul>
		<li>HTML keelt</li>
		<li>PHP programmeerimiskeelt</li>
		<li>SQL päringiukeelt</li>
		<li>jne</li>
	</ul>
	<?php echo $pic_html; ?>

</center>
</body>
</html>