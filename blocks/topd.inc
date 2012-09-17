<?
include "config.php";
$sql = mysql_query("SELECT * FROM ". $db_prefix ."files");
if(mysql_num_rows($sql) == "0") {
echo '<center>Brak plików w download\'zie.</center>';
} else {
$sql2 = mysql_query("SELECT * FROM ". $db_prefix ."files ORDER BY downloads DESC LIMIT 5");
$i = 1;
while($top=mysql_fetch_array($sql2)){
echo $i++;
echo '.<a href="download.php?func=fileinfo&id=' . $top[id] . '">' . $top[filename] . '</a> (' . $top[downloads] . ')<br>';
}
}
?>
