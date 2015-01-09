<?php

// Register the Twig templating engine
$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views',
));
$app->get('/twig/{name}', function ($name) use ($app) {
    return $app['twig']->render('index.twig', array(
        'name' => $name,
    ));
});
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Aktivitetsbank</title>
<link rel="stylesheet" href="styles/style.css">
<script type="text/javascript">
    function updateTextInput1(val) {
      document.getElementById('textInput1').value=val; 
    }
	function updateTextInput2(val) {
      document.getElementById('textInput2').value=val; 
    }
  </script>
</head>

<body>
<form  method="get">
	<input type="search" name="sokfras">
    <input type="submit">
    <br>
    <input type="range" style="width: 200px !important " name="age_1" min="0" max="40" value="0" onchange="updateTextInput1(this.value);">
    <input type="text" id="textInput1" value="0">
    <br>
    <input type="range" style="width: 200px !important " name="age_2" min="0" max="40" value="0" onchange="updateTextInput2(this.value);"> 
    <input type="text" id="textInput2" value="0">
</form>
<?php
if (isset($_GET["sokfras"])){
	
	$sokOrd =$_GET["sokfras"];
	
	if (isset($_GET["age_1"]) && $_GET["age_1"] != 0){
		 $sokOrd=$sokOrd.$_GET["age_1"];
	}
	if (isset($_GET["age_2"]) && $_GET["age_2"] != 0){
		 $sokOrd=$sokOrd.$_GET["age_2"];
	}
		$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
		$url="http://devscout.mikaelsvensson.info:10081/api/v1/activities?text=".$sokOrd;
		$contents = file_get_contents($url); 
		$results = json_decode($contents); 
		
		foreach ($results as $post){
			echo "<p>";
			echo "<h1> <a href='mer.php?id=".$post->id."'>".$post->name."</a></h1>";
			echo " Från ".$post->age_min;
			echo " till ".$post->age_max."år";
			echo "<br/>";
			echo $post->descr_introduction;
			echo "</p>";
	}
	
}else {
	echo "skriv ett sök ord";
}
?>
</body>
</html>