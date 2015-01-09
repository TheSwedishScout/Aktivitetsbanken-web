<?php
$urlPre ="http://devscout.mikaelsvensson.info:10081/api/v1/";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Aktivitetsbank</title>
<link rel="stylesheet" href="styles/style.css">
<?php include 'javaScript/funktions.php'; ?>

</head>

<body>
<form  method="get">
	<input type="search" name="sokfras">
    <input type="submit" value="Sök">
    <br>
    Min ålder
    <input type="range" style="width: 200px !important " name="age_1" min="0" max="40" value="0" onchange="updateTextInput1(this.value);">
    <input type="text" id="textInput1" value="0">
    <br>
    Max ålder
    <input type="range" style="width: 200px !important " name="age_2" min="0" max="40" value="0" onchange="updateTextInput2(this.value);"> 
    <input type="text" id="textInput2" value="0">
</form>
<?php
if (isset($_GET["id"])){
	$sokOrd =$_GET["id"];
	$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	$url=$urlPre."activities?id[]=".$sokOrd;
	$contents = file_get_contents($url); 
	$results = json_decode($contents); 

	echo "<div id='output' class='zeroMargin_mobile zeroMargin_tablet'>";
	
	foreach ($results as $post){
		
		echo "<header id='header'>";
		echo "<h1> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>";
		echo "</header>";
		
		echo "<div id='older_antal'><p>";
		echo "Från ".$post->age_min. " till ".$post->age_max."år. För ".$post->participants_min." till ".$post->participants_max." personer.";
		
		echo "<h2> Introduktion </h2><p>";
		echo $post->descr_introduction;
		echo "</p>";
		
		echo "<h2>Material</h2><p>";
		if (strlen($post->descr_material)> 0){
			echo $post->descr_material;
		} else {
			echo "Inget material behövs.";
		}
		echo "</p>";
		
		echo "<h2>Genomförande</h2>
			<p>";
			 $text = str_replace("#", "<br> #", $post->descr_main);
			 $text = str_replace("*", "<li>", $text);
			 $text = str_replace("# Att tänka på", "</p><h2>Att tänka på</h2><p> Att tänka på", $text);
			
			 echo $text;
			 
		
		echo "</p>";
		
		$media_items = count($post->media_files);// Start För bilder och sånt 
		if ($media_items > 0){
			echo "<h2>Bilder och sånt</h2><p>"; 
			foreach ($post->media_files as $media){
				switch ($media->mime_type) {
					case "application/pdf":
						echo "<a href='$media->uri'>$media->uri</a>";
						break;
					case "application/msword":
						echo "<a href='$media->uri'>Download</a>";
						break;
					case "image/jpeg":
						echo "<img src='$media->uri'>";
						break;
					case "image/png":
						echo "<img src='$media->uri'>";
						break;
						/*"application/vnd.openxmlformats-officedocument.presentationml.presentation"
						application/vnd.openxmlformats-officedocument.wordprocessingml.document
						"text/plain"
						application/zip
						
						
						
						*/
						
				}
			}
			echo "</p>"; 
		}// Slut för bilder och sånt
		
		$categories_items = count($post->categories);// Start Kategorier
		if ($categories_items > 0){
			echo "<h2> Kategorier</h2><p>";
			foreach ($post->categories as $cat){
				//echo $cat->name;
				if (isset ($cat->media_file->uri)){
					echo "<a href='category.php?category=$cat->id'>";
				echo '<img src="'.$cat->media_file->uri.'" title="'.$cat->name.'" width="60px">';
				echo "</a>";
//			/category/{id}
				}else{
					echo $cat->name;
				}
			}
			echo "</p>";//Slut Kategorier
		}
		
		//start Mer information
		if (isset ($post->references) && count($post->references)> 0){
			echo "<h2>Mer Info</h2><p>";
			foreach($post->references as $ref){
				if (isset($ref->description)){
					echo $ref->description;
				}
				if (isset($ref->uri)){
					//echo $ref->uri;
					echo "<a href='$ref->uri'>$ref->uri</a>";
				}	
			}
		}//Slut Mer Information
	echo "<br><br>";
	//print_r($post); //Debug rad --------------------------------------------------------------------------------DEBUG
	}
	
}
echo "</div>";

/* OM MAN GÖR EN NY SÖNKNIG START */
if (isset($_GET["sokfras"]) or isset($_GET["age_1"]) or isset($_GET["age_2"]) ){
	
	$sokOrd =$_GET["sokfras"];
	
	if (isset($_GET["age_1"]) && $_GET["age_1"] != 0){
		 $sokOrd=$sokOrd."&age_1=".$_GET["age_1"];
		 if ($_GET["age_2"] == 0){
			 $sokOrd=$sokOrd."&age_2=99";
			 }
	}
	if (isset($_GET["age_2"]) && $_GET["age_2"] != 0){
		 $sokOrd=$sokOrd."&age_2=".$_GET["age_2"];
	}
		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$url=$urlPre."activities?text=".$sokOrd;
		$contents = file_get_contents($url); 
		$results = json_decode($contents); 
		
		$resultcount = count($results);
		$sidcount = ($resultcount-1)/10;
		$sidcount = ceil($sidcount);
	for ($x = 1; $x <= $sidcount; $x++) {
    	echo '<input type="button" id="button_show_more" value="'.$x.'" onclick="showResults('.$x.')">&nbsp;&nbsp;';
	}
		//echo $sokOrd;
		$x=0;
		foreach ($results as $post){
			if ($x<=9){ $display = "style='display:block;'";}else { $display = "style='display:none;'";}
			echo '<div id="'.$x.'"'.$display.' class="result" >';
			echo "<h1> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>";
			echo " Från ".$post->age_min;
			echo " till ".$post->age_max."år";
			echo "<br/>";
			echo $post->descr_introduction; $x++;
			echo "</div>";
			
	}
	$resultcount = count($results);
	$sidcount = ($resultcount-1)/10;
	$sidcount = ceil($sidcount);
	?>
    	<div>
<!--		<input type="button" id="button_show_past" value="Förra" onClick="showPast()">-->
    <?php
	for ($x = 1; $x <= $sidcount; $x++) {
    	echo '<input type="button" id="button_show_more" value="'.$x.'" onclick="showResults('.$x.')">&nbsp;&nbsp;';
	}
	?>
		<!--<input type="button" id="button_show_next" value="Nästa" onclick="showNext()> -->
        </div>
    <?php
	echo "Antal sidor:".$sidcount;
}else {
	//echo "skriv ett sök ord";
}


?>
</body>
</html>