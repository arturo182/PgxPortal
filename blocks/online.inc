<?
include "config.php";
$query = mysql_query("SELECT * FROM ". $db_prefix ."stats") or die(mysql_error());
while($stats = mysql_fetch_array($query)){
$counter = $stats['counter'];
}

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online WHERE name='guest'") or die(mysql_error());
$onlineg = mysql_result($query, 0);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online WHERE name!='guest'") or die(mysql_error());
$onlineu = mysql_result($query, 0);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online") or die(mysql_error());
$online = mysql_result($query, 0);



echo 'Jest <b>'.$online.'</B> osób online: <b>'.$onlineg.'</b> go¶ci i <b>'.$onlineu.'</b> u¿ytkowników. Stronê odwiedzi³o ju¿ <a href="stats.php"><b>'.$counter.'</b></a> osób.';
?>
