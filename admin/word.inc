<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT id, word, replacement FROM ". $db_prefix ."words order by id ASC");
$numrows = mysql_num_rows($query);
if($numrows == '0') {
$tresc = "<center><b>Aktualnie nie ma ¿adnych s³ów</b><br><br><input type='button' value=' Dodaj nowe ' onClick=\"location.href='admin.php?mode=word&action=add#bottom';\"></center>";
} else
{
$tresc .= "<table width='100%' border='0' cellspacing='0' cellpadding='4' align='center'><tr><td class='header' align='center' width='33%'>S³owo</td><td class='header' align='center' width='33%'>Zamiennik</td><td class='header' align='center' width='33%'>Akcja</td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='4' align='center'>";

$ttnum = 1;
while($result = mysql_fetch_row($query)) {
$tresc .= "<tr><td align='center' width='33%'>&nbsp;".$result[1]."</td>\n";
$tresc .= "<td align='center' width='33%'>".$result[2]."</td>\n";
$tresc .= "<td align='center' width='33%'><a href='admin.php?mode=word&action=edit&id=".$result[0]."#bottom'>E</a> - <a href='admin.php?mode=word&action=delete&id=".$result[0]."#bottom'>U</a></td></tr>\n";
$ttnum = altcolors($ttnum);
}

$tresc .= "</table><br><br><center><input type='button' value=' Dodaj nowe ' onClick=\"location.href='admin.php?mode=word&action=add';\"></center>";
}

TableAdmin("Cenzura - $numrows s³ów",$tresc);
}

function edit() {
global $id,$db_prefix;
$query = mysql_query("SELECT word, replacement FROM ". $db_prefix ."words WHERE id = '$id' LIMIT 1");
$r = @mysql_fetch_array($query);
$word = $r[word];
$rep = $r[replacement];
$tresc .= "<form method='post' action='admin.php?mode=word#bottom'><table width='55%' border='0' cellspacing='0' cellpadding='4' align='center'><tr> <td width='50%' align='center'>S³owo</td><td width='50%' align='center'>Zamiennik</td></tr><tr><td width='50%' align='center'><input type='text' name='word' value='$word' size='25'></td><td width='50%' align='center'><input type='text' name='replacement' value='$rep' size='25'></td></tr><tr><td width='100%' align='center' colspan='2'><input type='hidden' value='edits' name='action'><input type='hidden' value='$id' name='id'><input type='submit' value=' Wyœli ' name='submit'></td></tr></form></table>";

TableAdmin("Cenzura",$tresc);

}

function edits() {
global $id, $word, $replacement,$db_prefix;
$query = mysql_query("UPDATE ". $db_prefix ."words SET word = '$word', replacement = '$replacement' WHERE id = '$id' LIMIT 1");
$tresc = "Zmiany zapisano.";

TableAdmin("Cenzura",$tresc);
}

function delete() {
global $id,$db_prefix;
mysql_query("DELETE FROM ". $db_prefix ."words WHERE id = '$id' LIMIT 1");
$tresc = "S³owo usuniêto";

TableAdmin("Cenzura",$tresc);
}

function add() {

$tresc .= "<form method='post' action='admin.php?mode=word&action=adds#bottom'><table width='55%' border='0' cellspacing='0' cellpadding='4' align='center'><tr><td width='50%' align='center'>S³owo</td><td width='50%' align='center'>Zamiennik</td></tr><tr><td width='50%' align='center'><input type='text' name='word' size='25'></td><td width='50%' align='center'><input type='text' name='replacement' size='25'></td></tr><tr><td width='100%' align='center' colspan='2'><input type='submit' value=' Wy¶li ' name='submit'></td></tr></form></table>";
		
TableAdmin("Cenzura",$tresc);
}

function adds() {
global $word, $replacement,$db_prefix;
$query = mysql_query("SELECT id FROM ". $db_prefix ."words WHERE word = '$word' LIMIT 1");
$numrows = mysql_num_rows($query);
if($numrows == '0') {
$query = mysql_query("INSERT INTO ". $db_prefix ."words (word, replacement) VALUES ('$word','$replacement')");
$tresc .= "S³owo dodane.";

} else {
$tresc .= "To s³owo juz jest na li¶cie!";
}

TableAdmin("Cenzura",$tresc);
}
?>
