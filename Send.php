<?php
require_once("MyDatabase.php");



if (!(isset($_POST['numer']) and isset($_POST['cash']) and isset($_POST['title']) and isset($_POST['token']))) {
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
}

if(!isset($_COOKIE['CSRFToken'])) {
    header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");

} else {
	$token = $_COOKIE['CSRFToken'];
	$cnftoken = (string)$_POST['token'];
	if(strcmp($token,$cnftoken) !== 0){
		header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
	}
	if(!password_verify('CSRFTOKEN',$token)){
		header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
	}
}

$numer = (string)$_POST['numer'];
$cash = (string)$_POST['cash'];
$title = (string)$_POST['title'];

$odp = array();
$db = myDB();

$db   = myDB();
 		$NICK = $_COOKIE['NICK'];
		$q    = "INSERT INTO historia(NICK,NUMER,VALUE,TITLE) VALUES(?,?,?,?)";
		$stmt = $db->prepare($q);
		$stmt-> bind_param("ssss", $NICK, $numer, $cash, $title);
		if ($stmt -> execute()){
			//report("INSERT OK");
			$db->close();
			header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/History.php");
		} else{
			//report("INSERT BŁAD");
			$db->close();
		$odp['stan'] = "1";
			header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/index.html");
		};
		




	
?>