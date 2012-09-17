<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."page");

$how_pages = mysql_num_rows($query);
if($how_pages == "0")
{
$tresc = "Brak Stron informacyjnych";
}
else
{
$tresc = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td width=\"5%\">ID</td><td width=\"60%\">Nazwa</td><td width=\"10%\" align=\"center\">Edytuj</td><td width=\"10%\" align=\"center\">Usuñ</td></tr>";

while($article=mysql_fetch_array($query)){
$tresc .= "<tr><td>" . $article['id'] . "</td><td>" . $article['title'] . "</a></td><td align=\"center\"><a href=\"admin.php?mode=pages&action=edit&id=" . $article['id'] . "#bottom\">E</a><td  align=\"center\"><a href=\"admin.php?mode=pages&action=delete&id=" . $article['id'] . "#bottom\">U</a></td></tr>";
}
$tresc .="</table>";
}

TableAdmin("Strony informacyjne","$tresc");
}

function edit() {
global $id,$db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."page where id='$id'");
while($article=mysql_fetch_array($query)){
$text = $article['text'];
$title = $article['title'];
}
$tresc = "<form method='post' action='admin.php?mode=pages#bottom'><table border='0' cellpadding='1' cellspacing='0' width='100%'><tr><td>Tytu³:</td><td><input type='text' name='edit_pages_title' value='$title' size='15'></td></tr><tr><td valign='top'>Tre¶æ:</td><td><textarea cols='65' rows='10' name='edit_pages_text'>$text</textarea></td></tr><tr><td><input type='submit' value='Wy¶li'><input type='hidden' name='action' value='edits'><input type='hidden' name='edit_pages_id' value='$id'></td></tr></table></form>";

TableAdmin("Strony informacyjne","$tresc");
}

function edits() {
global $edit_pages_title, $edit_pages_text, $edit_pages_id,$db_prefix;
mysql_query("UPDATE ". $db_prefix ."page SET `title` = '$edit_pages_title',`text` = '$edit_pages_text' WHERE `id` = '$edit_pages_id' LIMIT 1");
$tresc = "Zmiany w stronie zapisano.";

TableAdmin("Strony informacyjne","$tresc");
}

function delete() {
global $id,$db_prefix;
mysql_query("DELETE FROM ". $db_prefix ."page WHERE `id` = '$id'");
$tresc = "Stronê usuniêto.";

TableAdmin("Strony informacyjne","$tresc");
}

function add() {
$tresc = "Strony informacyjne to artyku³y w których mo¿na kozystaæ z HTML'a i do których nie trzeba tworzyæ kategorii. Po dodanuiu strony informacyjnej wy¶wietlony jej adres.<form method='post' action='admin.php?mode=pages#bottom'><table border='0' cellpadding='1' cellspacing='0' width='100%'><tr><td>Tytu³:</td><td><input type='text' name='add_pages_title' value='' size='15'></td></tr><tr><td>Nl2Br:*</td><td><input type='checkbox' name='add_pages_nl2br' checked></td></tr><tr><td valign='top'>Tre¶æ:</td><td><textarea cols='65' rows='10' name='add_pages_text'></textarea></td></tr><tr><td><input type='submit' value='Wy¶li'><input type='hidden' name='action' value='adds'></td></tr><tr><Td></td><td>* Czy zamieniaæ nowe linie(entery) na znaczniki &lt;br&gt;?</td></tr></table></form>";

TableAdmin("Dodaj stronê informacyjn±","$tresc");
}

function adds(){
global $add_pages_text, $add_pages_title,$add_pages_nl2br,$db_prefix;
mysql_query("INSERT INTO ". $db_prefix ."page ( `id` , `title` , `text`, `nl2br`) VALUES ('NULL', '$add_pages_title', '$add_pages_text', '$add_pages_nl2br')");
$pid = mysql_insert_id();
$tresc = "Stronê dodano, jej adres to <b>page.php?id=$pid</b>";

TableAdmin("Dodaj stronê informacyjn±","$tresc");
}
?>
