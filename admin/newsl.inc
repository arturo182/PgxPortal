<?
include "config.php";
function nothing() {
$tresc = "<table border='0' cellpadding='2' cellspacing='0' width='100%'>
 <form method='post' action='admin.php?mode=newsl#bottom'>
  <tr>
    <td>Temat:</td>
    <td><input type='text' name='subject' size='40'></td>
  </tr>
  <tr>
    <td valign='top'>Tre¶æ:</td>
    <td><textarea rows='10' name='message' cols='75'></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type='submit' name='submit' value='Roze¶li'><input type='hidden' name='action' value='send'></td>
  </tr>
 </form>
</table>";

TableAdmin("Subskrypcja",$tresc);
}

function send() {
global $message,$subject,$db_prefix;
$tresc .= "Poczekaj, a¿ za³aduje siê ca³a strona, d³ugoœæ ³adowania zale¿y od liczby u¿ytkowników.<br><br>";
      $query = mysql_query("SELECT * FROM ". $db_prefix ."config");
      $result = mysql_fetch_array($query);
      $owner = $config['owner'];
      $adminemail = $config['adminemail'];
      $sitename = $config['sitename'];

	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$message = stripslashes($message);
	$query = mysql_query("SELECT * FROM ". $db_prefix ."member") or die(mysql_error());
	while ($row = mysql_fetch_array($query)) {
		$name = $row['username'];
		$email = $row['email'];
		mail("$owner <$adminemail>", "$subject", "$message", "From: $sitename");
 	}
$tresc .= "Em@ile rozes³ano.";

TableAdmin("Subskrypcja",$tresc);
}
?>
