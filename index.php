<?php
/*
// Register the Twig templating engine
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views',
));
$app->get('/twig/{name}', function ($name) use ($app) {
    return $app['twig']->render('index.twig', array(
        'name' => $name,
    ));
});*/
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
    <input type="submit">
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
	echo "skriv ett sök ord";
}
?>
</body>
</html>