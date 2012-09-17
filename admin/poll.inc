<?
include "config.php";
function nothing() {
global $db_prefix;
$tresc = "<table border='0' width='100%' cellpadding='4' cellspacing='0'>";
$result = mysql_query("SELECT * FROM ". $db_prefix ."poll_title ORDER BY id desc LIMIT 1");
while ($myrow = mysql_fetch_array($result)){
$tresc .= "<tr><td align='center'><b>Pytanie:</b> ".$myrow['title']."</TD></TR>";
$naslov = $myrow['id'];
if($myrow['active'] == "on") {
$check = "checked";
}
$tresc .= "<tr><td align='center'><form action='admin.php?mode=poll&action=active#bottom' method='post'>w³±czona: <input type='hidden' name='id' value='$naslov'><input type='checkbox' name='actived' onchange='this.form.submit()' $check>&nbsp;</form></TD></TR>";
}
$all = "0";
$result2 = mysql_query("SELECT * FROM ". $db_prefix ."poll WHERE title='$naslov'");
while ($myrow = mysql_fetch_array($result2)){

$tresc .= "<tr><td align='center'><form name='form" .$myrow[id]. "' method='post' action='admin.php?mode=poll&action=deledit#bottom'><input type='hidden' name='id' value='".$myrow[id]."'><table border='0'><tr><td>Odpowied¼:</td><td><input type='content' name='content' value='".$myrow['content']."'></td></tr><tr><td>G³osów:</td><td><input type='text' name='number' value='".$myrow[number]."'></td></tr><tr><td colspan='2' align='center'><input type='submit' name='Submit' value='Usuñ'> <input type='submit' name='Submit' value='Edytuj'></form></td></tr></table></TD></TR>";

}
$tresc .= "</table>";

TableAdmin("Ankieta",$tresc);
}

function deledit() {
global $content,$number,$id,$Submit,$db_prefix;

if ($Submit == "Edytuj") {
mysql_query("UPDATE ". $db_prefix ."poll SET content='$content', number='$number' WHERE id='$id'");
$tresc = "Odpowied¼ zmieniono.";

TableAdmin("Ankieta",$tresc);
}

if ($Submit == "Usuñ") {
mysql_query("DELETE FROM ". $db_prefix ."poll WHERE id='$id'");
$tresc = "Odpowied¼ usuniêto.";

TableAdmin("Ankieta",$tresc);
}
}

function add() {
global $db_prefix;
$tresc .= "<b>UWAGA!</b> Aby umie¶ciæ ankietê w bloku menu nale¿y wpisaæ ||poll|| w tre¶æ tego bloku.";
$tresc .= "<table border='0' width='100%'><tr><td>Pytanie:</td><td><table><tr><td><form method='post' action='admin.php?mode=poll&action=addtitle#bottom'><input type='text' name='title_of_poll'></td><td><input type='submit' name='Submit' value='OK'></td></tr></table></form></td></tr><tr><td>Odpowied¼:</td><td><table><tr><td><form name='pollf' method='post' action='admin.php?mode=poll&action=addfield'><input type='text' name='field'></td><td><input type='submit' name='Submit' value='OK'></td></tr></table></form></td></tr><tr><td> </td><td>&nbsp;</td></tr><tr><td valign='top'>Podgl±d:</td><td>";

$result = mysql_query("SELECT * FROM ". $db_prefix ."poll_title ORDER BY id DESC LIMIT 1");
while ($myrow = mysql_fetch_array($result)){
$title = $myrow['title'];
$naslov = $myrow['id'];
}
$title = stripslashes($title);

$tresc .= "<table border='0' width='150' cellpadding='3' cellspacing='0'><form name='poll' method='post' action='pollr.php'><tr><td><b>".$title."</b></td></tr>";

$result2 = mysql_query("SELECT * FROM ". $db_prefix ."poll WHERE title='$naslov' ORDER BY id ASC");
$tresc .= "<tr><td><table border='0' width='100%' cellpadding='1' cellspacing='0'>";

while ($myrow = mysql_fetch_array($result2)){
$myrow['content'] = stripslashes($myrow['content']);
$tresc .= "<tr><td><input type='radio' name='id' value='".$myrow['id']."'> ".$myrow['content']."</td></tr>";
}

$tresc .= "<tr><td><input type='submit' name='Submit' value='G³osuj'></td></tr></form></table></td></tr></table>";

$tresc .= "</td></tr></table>";

TableAdmin("Dodaj ankietê","$tresc");
}

function addtitle() {
global $title_of_poll,$db_prefix;
$title_of_poll = addslashes($title_of_poll);
mysql_query("INSERT INTO ". $db_prefix ."poll_title (title,active) VALUES ('$title_of_poll','on')");
$tresc = "Pytanie dodano.";

TableAdmin("Ankieta",$tresc);
}

function addfield(){
global $field,$db_prefix;
$result = mysql_query("SELECT * FROM ". $db_prefix ."poll_title ORDER BY id DESC LIMIT 1");
while ($myrow = mysql_fetch_array($result)){
$id = $myrow[id];
}


$filed = addslashes($field);
mysql_query("INSERT INTO ". $db_prefix ."poll (content, title) VALUES ('$field','$id')");
$tresc = "Odpowied¼ dodano.<br><a href='admin.php?mode=poll&action=add#bottom'>Dodaj nastepn±</a>";

TableAdmin("Ankieta",$tresc);
}
function active() {
global $actived,$id,$db_prefix;
if($actived != 'on') {
$de = "de";
}
mysql_query("UPDATE ". $db_prefix ."poll_title SET `active` = '$actived' WHERE `id` = '$id';");

TableAdmin("Ankieta","Ankietê ".$de."aktywowano.");
}
?>
