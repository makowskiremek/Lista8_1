<?php
require_once("MyDatabase.php");


if (!(isset($_POST['code']) and isset($_POST['pass']) and isset($_POST['pass2']))){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Recovery.html");
}

$NICK = $_COOKIE['NICK'];
$CODE = (string)$_POST['code'];
$PASS = (string)$_POST['pass'];
$PASS2 = (string)$_POST['pass2'];
echo($NICK);

if($PASS != $PASS2){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Recovery.html");
	exit;
}

$odp = array();
$db = myDB();
	$q  = "SELECT RESCUE FROM login where NICK = \"". $NICK ."\" LIMIT 1";
	$result = $db->query($q) or die($db->error);
	if ($row = $result->fetch_row()){
			$odp['stan'] =  $row[0];
		} else {
			$odp['stan'] =  0;
		}
		$db->close();
echo($odp['stan']);
if ($odp['stan'] != $CODE || $CODE == "") {
    header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Recovery.html");
   	exit;
} else {
	$db = myDB();
	$q    = 'UPDATE login SET RESCUE = "", PASS = ? where NICK = ?';
		$stmt = $db->prepare($q);
		$stmt-> bind_param("ss", password_hash($PASS, PASSWORD_DEFAULT), $NICK);
		if ($stmt -> execute()){
			//report("INSERT OK");
		} else{
			//report("INSERT BŁAD");
			echo "BŁAD";
		};
		$db->close();
}



header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/index.html");
	
?>