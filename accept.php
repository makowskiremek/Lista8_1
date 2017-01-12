<?php
require_once("MyDatabase.php");



if (!(isset($_POST['id']) and $_COOKIE['NICK'] == "admin")) {
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
}



$numer = (string)$_POST['id'];

$odp = array();
$db = myDB();

$db   = myDB();
 		$NICK = $_COOKIE['NICK'];
		$q    = "UPDATE historia SET CONFIRM = 1 where ID = ?";
		$stmt = $db->prepare($q);
		$stmt-> bind_param("s", $numer);
		if ($stmt -> execute()){
			//report("update OK");
			$db->close();
			header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/adminForm.php");
		} else{
			//report("update BŁAD");
			$db->close();
		$odp['stan'] = "1";
			header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/index.html");
		};
		




	
?>