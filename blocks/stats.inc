<?
include "config.php";
echo' Twoje IP: <b>'. $_SERVER['REMOTE_ADDR'] .'</b><br>';
echo 'Tw�j host: <b>'. gethostbyaddr($_SERVER['REMOTE_ADDR']) .'</b><br><hr>';

echo "<table width='100%' cellpadding='2' cellspacing='1' border='0'>";

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."articles");
$result = mysql_result($query, 0);
echo  "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Artyku��w:</td><td background='themes/$theme/gfx/bg$ttnum.gif'><b>$result</b></td></tr>";


$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."files");
$result = mysql_result($query, 0);
echo  "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Plik�w:</td><td background='themes/$theme/gfx/bg$ttnum.gif'><b>$result</b></td></tr>";

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."news");
$result = mysql_result($query, 0);
echo  "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>News�w:</td><td background='themes/$theme/gfx/bg$ttnum.gif'><b>$result</b></td></tr>";

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."post");
$result = mysql_result($query, 0);
echo  "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Post�w na forum:</td><td background='themes/$theme/gfx/bg$ttnum.gif'><b>$result</b></td></tr>";


$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."topic");
$result = mysql_result($query, 0);
echo  "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Temat�w na forum:</td><td background='themes/$theme/gfx/bg$ttnum.gif'><b>$result</b></td></tr>";


echo  "</table>";
?>
