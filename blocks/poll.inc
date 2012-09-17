<?
include "config.php";
$result = mysql_query("SELECT * FROM ". $db_prefix ."poll_title WHERE active='on' ORDER BY id DESC LIMIT 1");
if(mysql_num_rows($result) == "0") {
echo '<center>Aktualnie nie jest prowadzona ¿adna sonda.</center>';
} else {
while ($myrow = mysql_fetch_array($result)){
$title = $myrow['title'];
$naslov = $myrow['id'];
}

$title = stripslashes($title);
echo '<table width="100%" cellpadding="0" cellspacing="0"><tr><td><table border="0" width="100%" cellpadding="3" cellspacing="0"><form name="poll" method="post" action="pollr.php"><tr><td><b>'.$title.'</b></td></tr>';

$result2 = mysql_query("SELECT * FROM ". $db_prefix ."poll WHERE title='$naslov' ORDER BY id ASC");
echo '<tr><td><table border="0" width="100%" cellpadding="1" cellspacing="0">';
while ($myrow = mysql_fetch_array($result2)){
$myrow['content'] = stripslashes($myrow['content']);
echo '<tr><td><input type="radio" name="id" value="'.$myrow[id].'"> '.$myrow[content].'</font></td></tr>';
}
echo '<tr><td align="center"><input type="submit" name="submit" value="G³osuj"></td></tr><tr><td align="center"><a href="pollr.php">Wyniki</a></td></tr></form></table></td></tr></table></td></tr></table>';
}
?>
