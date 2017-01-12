<?php
require_once("MyDatabase.php");



if (!(isset($_POST['id']) )){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
}

/*
$db   = myDB();
		$log  = "USER";
		$psw  = password_hash("pass", PASSWORD_DEFAULT);
		$q    = "INSERT INTO login(NICK,PASS) VALUES(?,?)";
		$stmt = $db->prepare($q);
		$stmt-> bind_param("ss", $log, $psw);
		if ($stmt -> execute()){
			//report("INSERT OK");
		} else{
			//report("INSERT BŁAD");
		};
		$db->close();
		$odp['stan'] = "1";
*/

$PASS = (string)$_POST['id'];

$odp = array();
$db = myDB();
	$q  = "SELECT NICK FROM login where GOOGLEID = \"". $PASS ."\" LIMIT 1";
	$result = $db->query($q) or die($db->error);
	if ($row = $result->fetch_row()){
			$odp['stan'] =  $row[0];
		} else {
			$odp['stan'] =  0;
		}
		$db->close();
echo($odp['stan']);
if ($odp['stan'] == '0') {
    echo('Fail.');
} else {
    setcookie('NICK',    $odp['stan']);
    	if($odp['stan'] == "admin"){
    		header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/adminForm.php");
			exit;
    	}
		header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Form.html");
		exit;
}



//header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/index.html");
	
?>