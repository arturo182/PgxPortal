<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."guest_book ORDER BY date DESC");
$how_rows = mysql_num_rows($query);
if($how_rows == "0")
{
$tresc = "Brak wpisów w ksiêdze";
}
else
{
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='40%'>Tre¶æ</td><td width='15%'>Autor</td><td width='20%'>Data</td><td width='5%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
$tresc .= "<tr><td>" . $row['text'] . "</td><td  valign='top'><a href='mailto:" . $row['email'] . "'>" . $row['author'] . "</a></td><td  valign='top'>" .  date("Y-m-d H:i", $row['date']) . "</td><td align='center' valign='top'><a href='admin.php?mode=guestbook&action=delete&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .= "</table>";
}
TableAdmin("Ksiega go¶ci","$tresc");
}

function delete() {
global $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."guest_book WHERE id='$id'");
$tresc = "Wpis usuniêto.";

TableAdmin("Ksiêga go¶ci","$tresc");
}
?>
