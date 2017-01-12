<?php
require_once("MyDatabase.php");

$Message = <<<EOT
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>
<body>
Your Reset Password code is: {{RESET}}
</body>
</html>
EOT;

if (!(isset($_POST['NICK']) )){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Recovery.html");
}



$NICK = (string)$_POST['NICK'];

$odp = array();
$db = myDB();
	$q  = "SELECT EMAIL FROM login where NICK = \"". $NICK ."\" LIMIT 1";
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
	$psw  = password_hash("reset", PASSWORD_DEFAULT);
	$db = myDB();
	$q    = "UPDATE login SET RESCUE = ? where NICK = ?";
		$stmt = $db->prepare($q);
		$stmt-> bind_param("ss", $psw, $NICK);
		if ($stmt -> execute()){
			//report("INSERT OK");
		} else{
			//report("INSERT BŁAD");
		};
		$db->close();
		$Message = (string) str_replace("{{RESET}}", $psw,  $Message);
		$Message = wordwrap($Message, 70, "\r\n");
		$msg = "Your Reset Password code is: ".$psw;
		$msg = wordwrap($msg, 70, "\r\n");
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	$headers[] = 'To: REMEK <makowski.remigiusz@wp.pl>';
	$headers[] = 'From: Your PC <localhost@example.com>';
    mail($odp['stan'], "Localhost Password Recovery", $msg);
setcookie('NICK',    $NICK);
}



header("location: http://" . $_SERVER['HTTP_HOST'] ."/Krypto/Recovery.html");
	
?>