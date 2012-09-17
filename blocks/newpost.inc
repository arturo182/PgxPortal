<?
include "config.php";
$sql = mysql_query("SELECT * FROM ". $db_prefix ."post");
if(mysql_num_rows($sql) == "0")
{
 echo '<center>Brak postów na forum.</center>';
}
else
{
$sql2 = mysql_query("SELECT * FROM ". $db_prefix ."post ORDER BY dateline DESC LIMIT 10");
while($top=mysql_fetch_array($sql2))
{
$subject = postify(shorter($top[subject],"30"));

echo '<font class="p">&raquo;</font> <a href="topic.php?tid=' . $top[tid] . '#' . $top[pid] . '">'. $subject .'</a><br>';
}
}
?>
