<?php



if (!(isset($_POST['numer']) and isset($_POST['cash']) and isset($_POST['title']))){
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Form.html");
}




$NUM = (string)$_POST['numer'];
$CASH = (string)$_POST['cash'];
$TITLE = (string)$_POST['title'];

$encoding = "UTF-8";
//if(strpos($TITLE, '<script>') !== false){
	//header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/Form.html");
	$TITLE = htmlspecialchars($TITLE,ENT_QUOTES | ENT_HTML401,$encoding);
	//exit();
//}


$Tekst = <<<EOT
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>
<body>
<span>Potwierdź dane</span><br>
<span>Tytuł: {{TIT}}</span><br>
<span>Numer Konta: {{NUMER}}</span><br>
<span>Kwota: {{CASH}}</span><br>
<form id="myForm" action="Send.php" method="post">
{{ENTITY1}}
{{ENTITY2}}
{{ENTITY3}}
{{TOKEN}}
<input type="submit"  class="button" value="Wyślij przelew"><br>
</form>
</body>
</html>
EOT;
$psw  = password_hash("CSRFTOKEN", PASSWORD_DEFAULT);
$S = (string) str_replace("{{NUMER}}", $NUM,  $Tekst);
$S = (string) str_replace("{{ENTITY1}}", "<input id=\"n\" type=\"hidden\" name=\"numer\" value=\"" . $NUM . "\">",  $S);
$S = (string) str_replace("{{ENTITY2}}", "<input id=\"c\" type=\"hidden\" name=\"cash\" value=\"" . $CASH . "\">",  $S);
$S = (string) str_replace("{{ENTITY3}}", "<input id=\"t\" type=\"hidden\" name=\"title\" value=\"" . $TITLE . "\">",  $S);
$S = (string) str_replace("{{TOKEN}}", "<input id=\"token\" type=\"hidden\" name=\"token\" value=\"" . $psw . "\">",  $S);
$S = (string) str_replace("{{CASH}}", $CASH,  $S);
$S = (string) str_replace("{{TIT}}", $TITLE,  $S);
setcookie('CSRFToken',    $psw);
echo($S);

	
?>