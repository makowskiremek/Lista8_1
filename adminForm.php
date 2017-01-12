<?php
require_once("MyDatabase.php");

if (!($_COOKIE['NICK'] == "admin")) {
	header("location: http://" . $_SERVER['HTTP_HOST'] . "/Krypto/index.html");
}

$NICK = $_COOKIE['NICK'];


$Tekst = <<<EOT
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8"/>
</head>
<body>
<span>Historia przelewów: </span><br>
<table id="result">
<tr>
<th>Id</th>
<th>Wysyłający</th>
<th>odbiorca</th>
<th>kwota</th>
<th>Tytuł</th>
<th>Akceptacja</th>
</tr>
{{ELEM}}
</table>
<br>
<form method="post" action="accept.php">
<div class="padd">
	<span>ID:&nbsp;        </span> <input id="input" type="number"     name="id" size="6" minlength="1" maxlength="10"><br>
</div>
	<input type="submit"  class="button" value="Zaakceptuj">
</form>
</body>
</html>
EOT;

$db = myDB();
		$q  = "SELECT ID,NICK,NUMER,VALUE, TITLE, CONFIRM FROM (SELECT ID,NICK,NUMER,VALUE,TITLE,CONFIRM FROM historia ORDER BY ID DESC) sub ORDER BY ID ASC ";
		//report("PYTANIE: " . $q);
		$result = $db -> query($q);
		while ($row = $result->fetch_assoc()) {
			$Tekst = (string) str_replace("{{ELEM}}", "<tr><th>". $row['ID'] ."</th><th>".$row['NICK']."</th><th>".$row['NUMER']."</th><th>".$row['VALUE']."</th><th>". htmlspecialchars($row['TITLE'],ENT_QUOTES | ENT_HTML401,"UTF-8") ."</th><th>". $row['CONFIRM'] ."</th></tr>{{ELEM}}",  $Tekst);
		}
		$db->close();


$Tekst = (string) str_replace("{{ELEM}}", "",  $Tekst);


echo($Tekst);




?>