<?php
require_once("MyDatabase.php");



if (!(isset($_POST['NICK']) and isset($_POST['pass']) and isset($_POST['g-recaptcha-response']))){
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

$NICK = (string)$_POST['NICK'];
$PASS = (string)$_POST['pass'];

if(strpos($NICK,'"') !== false || strpos($NICK,';') !== false || strpos($NICK,"'") !== false || strpos($NICK,'/') !== false || strpos($NICK,'\\') !== false){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
}

$secretKey = "6Lfk5w4UAAAAABh1pw600lUxWIdAID6IqJbhwe8_";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
 if(intval($responseKeys["success"]) !== 1) {
          echo '<h2>You are ROBOT</h2>';
          exit;
        } else {
          
        }

$odp = array();
$db = myDB();
	$q  = "SELECT PASS FROM login where NICK=? LIMIT 1";
	//$result = $db->query($q) or die($db->error);

	$stmt = $db->prepare($q);
	$stmt->bind_param("s",$NICK);

	if($stmt -> execute()){


		$stmt->bind_result($odp['stan']);
    	$stmt->fetch();
		
		$db->close();
	} else {
		//Błąd
	}


/*	if ($row = $result->fetch_row()){
			$odp['stan'] =  $row[0];
		} else {
			$odp['stan'] =  0;
		}
		$db->close();*/
echo($odp['stan']);
if (password_verify($PASS, $odp['stan'])) {
    setcookie('NICK',    $NICK);
    	if($NICK == "admin"){
    		header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/adminForm.php");
			exit;
    	}
		header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Form.html");
		exit;
} else {
    echo 'Invalid password.';
}



header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/index.html");
	
?>