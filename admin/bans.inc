<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."bans");
$numrows = mysql_num_rows($query);
if($numrows == '0') {
$tresc = "<center><b>Aktualnie nie ma ¿adnych zbanowanych IP.</b><br><br><input type='button' value=' Dodaj nowe IP ' onClick=\"location.href='admin.php?mode=bans&action=add#bottom';\"></center>";
} else
{
$tresc .= "<table width='100%' border='0' cellspacing='0' cellpadding='4' align='center'><tr><td class='header' align='center' width='33%'>IP</td><td class='header' align='center' width='33%'>Akcja</td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='4' align='center'>";

$ttnum = 1;
while($result = mysql_fetch_row($query)) {
$tresc .= "<tr><td align='center' width='33%'>&nbsp;".$result[1]."</td>\n";
$tresc .= "<td align='center' width='33%'><a href='admin.php?mode=bans&action=edit&id=".$result[0]."#bottom'>E</a> - <a href='admin.php?mode=bans&action=delete&id=".$result[0]."#bottom'>U</a></td></tr>\n";
$ttnum = altcolors($ttnum);
}

$tresc .= "</table><br><br><center><input type='button' value=' Dodaj nowe IP ' onClick=\"location.href='admin.php?mode=bans&action=add#bottom';\"></center>";
}

TableAdmin("Banicja - $numrows IP",$tresc);
}

function edit() {
global $id,$db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."bans WHERE id = '$id' LIMIT 1");
$r = @mysql_fetch_array($query);
$ip= $r[ip];
$tresc .= "<form method='post' action='admin.php?mode=bans#bottom'><table width='55%' border='0' cellspacing='0' cellpadding='4' align='center'><td width='50%' align='center'><input type='text' name='ip' value='$ip' size='25'></td></tr><tr><td width='100%' align='center' colspan='2'><input type='hidden' value='edits' name='action'><input type='hidden' value='$id' name='id'><input type='submit' value=' Zapisz ' name='submit'></td></tr></form></table>";

TableAdmin("Banicja",$tresc);

}

function edits() {
global $id, $ip,$db_prefix;
$query = mysql_query("UPDATE ". $db_prefix ."bans SET ip = '$ip' WHERE id = '$id' LIMIT 1");
$tresc = "Zmiany zapisano.";

TableAdmin("Banicja",$tresc);
}

function delete() {
global $id;
mysql_query("DELETE FROM ". $db_prefix ."bans WHERE id = '$id' LIMIT 1");
$tresc = "Bana usuniêto";

TableAdmin("Banicja",$tresc);
}

function add() {

$tresc .= "Podaj IP (w formacie xx.xx.xx.xx):<form method='post' action='admin.php?mode=bans&action=adds#bottom'><table width='55%' border='0' cellspacing='0' cellpadding='4' align='center'><tr><td width='50%' align='center'><input type='text' name='ipa' size='25'></td></tr><tr><td width='100%' align='center' colspan='2'><input type='submit' value=' Wy¶li ' name='submit'></td></tr></table></form>";
		
TableAdmin("Banicja",$tresc);
}

function adds() {
global $ipa,$db_prefix;
$query = mysql_query("SELECT id FROM ". $db_prefix ."bans WHERE ip = '$ipa' LIMIT 1");
$numrows = mysql_num_rows($query);
if($numrows == '0') {
$query = mysql_query("INSERT INTO ". $db_prefix ."bans (ip) VALUES ('$ipa')");
$tresc .= "IP zbanowane.";

} else {
$tresc .= "To IP ju¿ jest na li¶cie!";
}

TableAdmin("Banicja",$tresc);
}
?>
