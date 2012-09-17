<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."articles_folders");
$how_articles_folder = mysql_num_rows($query);
if($how_articles_folder == "0")
{
$tresc .= "Nie ma ¿adnych kategorii.";
}
else
{
$tresc .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='30%'>Nazwa</td><td width='50%' >Opis</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
$tresc .= "<tr><td>" . $row['id'] . "</td><td><a href='admin.php?mode=articles&action=folder&id=" . $row['id'] . "#bottom'>" .  $row['name'] . "</a></td><td>" . $row['description'] . "</td><td align='center'><a href='admin.php?mode=articles&action=edit&id=" . $row['id'] . "#bottom'>E</a></td><td align='center'><a href='admin.php?mode=articles&action=delete&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
}
}

$tresc .="</table>";
TableAdmin("Artyku³y - Kategorie","$tresc");
}

function edita() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."articles");
$how_articles_folder = mysql_num_rows($query);
if($how_articles_folder == "0")
{
$tresc .= "Nie ma ¿adnych artyku³ów.";
}
else
{
$tresc .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='30%'>Nazwa</td><td width='50%'>Katalog</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
 $folder = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."articles_folders WHERE id='$row[folder]'"));
  $tresc .= "<tr><td>" . $row['id'] . "</td><td><a href='articles.php?id=" . $row['id'] . "'>" .  $row['title'] . "</a></td><td>" . $folder['name'] . "</td><td align='center'><a href='admin.php?mode=articles&action=editf&id=" . $row['id'] . "#bottom'>E</a></td><td align='center'><a href='admin.php?mode=articles&action=deletef&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
 }
}

$tresc .="</table>";
TableAdmin("Artyku³y","$tresc");
}



function folder() {
global $id,$db_prefix;;

$query = mysql_query("SELECT * FROM ". $db_prefix ."articles WHERE folder='$id'");
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='60%'>Nazwa</td><td width='25%' align='center'>Data</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";

while($article=mysql_fetch_array($query)){
$tresc .= "<tr><td>" . $article['id'] . "</td><td>" . $article['title'] . "</a></td><td>" .datepl(date("d-m-Y H:i", $article['date'])) . "</td><td align='center'><a href='admin.php?mode=articles&action=editf&id=" . $article['id'] . "#bottom'>E</a><td  align='center'><a href='admin.php?mode=?mode=articles&action=deletef&id=" . $article['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .="</table>";
$query = mysql_query("SELECT * FROM ". $db_prefix ."articles_folders where id='$id'");
while($row = mysql_fetch_array($query)) { $name = $row['name']; }
$tresc .= "<br><br><a href='admin.php?mode=articles#bottom'>..</a>";

TableAdmin("Artyku³y -> $name","$tresc");
}

function edit() {
global $id,$db_prefix;

$query = mysql_query("SELECT * FROM ". $db_prefix ."articles_folders where id='$id'");
while($article=mysql_fetch_array($query)){
$name = $article['name'];
$description = $article['description'];
}
$tresc = "<table cellspacing='3'><FORM METHOD='POST' ACTION='admin.php?mode=articles&action=edits#bottom'><tr><td>Nazwa foldera: </td><td><input type='text' name='name' size='25' value='$name'></td></tr><tr><td>Opis foldera: </td><td><TEXTAREA NAME='description' ROWS='4' COLS='35'>$description</TEXTAREA></td></tr><tr><td><input type='hidden' name='id' value='$id'><INPUT TYPE='submit' VALUE='Zapisz'></td></tr></table></FORM>";


TableAdmin("Kategorie artyku³ów","$tresc");
}

function edits() {
global $id,$name,$description,$db_prefix;

mysql_query("UPDATE ". $db_prefix ."articles_folders SET `name` = '$name',`description` = '$description' WHERE `id` = '$id'");
$tresc = "Kategoriê zapisano. ";

TableAdmin("Kategorie artyku³ów","$tresc");
}

function delete() {
global $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."articles_folders WHERE `id` = '$id'");
mysql_query("DELETE FROM ". $db_prefix ."articles WHERE `folderid` = '$id'");
$tresc = "Kategoriê i artyku³y w niej zawarte usuniêto.";

TableAdmin("Kategorie artyku³ów","$tresc");
}

function editf() {
global $id,$theme,$db_prefix;

$query = mysql_query("SELECT * FROM ". $db_prefix ."articles where id='$id'");
$article=mysql_fetch_array($query);

$text = $article['text'];
$title = $article['title'];
$folder = $article['folder'];


$smileytd = 1;
$query = mysql_query("SELECT * FROM ". $db_prefix ."smiley ORDER BY sid ASC") or die(mysql_error());
while($smiley = mysql_fetch_array($query)) {
if($smileytd == 1) {
$autosmiley .= "<tr>
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>";
$smileytd = 2;
} elseif($smileytd == 2) {
$autosmiley .= "
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>";
$smileytd = 3;
} elseif($smileytd == 3) {
$autosmiley .= "
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>";
$smileytd = 4;
} elseif($smileytd == 4) {
$autosmiley .= "
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>
</tr>";
$smileytd = 1;
}
}

$tresc = "<script language='javascript1.2' src='nb.js' type=text/javascript></script>
<form method='post' action='admin.php?mode=articles&action=editsf#bottom' name='input'>
<table border='0' cellpadding='3' cellspacing='1' width='100%'>
<tr>
  <td width='22%' background='themes/$theme/gfx/bg1.gif'><b>Temat</b></td>
  <td background='themes/$theme/gfx/bg2.gif'><input type='text' name='ttitle' style='width: 307px' value='$title'>
  </td>
</tr>
<tr>
  <td width='22%' background='themes/$theme/gfx/bg1.gif'><b>Kategoria</b></td>
  <td background='themes/$theme/gfx/bg2.gif'><select name='folderid' style='width: 307px;'>";
$sql = "SELECT * FROM ". $db_prefix ."articles_folders";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$folder_id = $row['id'];
$folder_name = $row['name'];
if($folder == $folder_name) {
$sel = "selected";
}
$tresc .= "<option value='$folder_id' $sel>$folder_name</option>";
}
$tresc .= "</select>
  </td>
</tr>
<tr>
  <td valign='top' background='themes/$theme/gfx/bg1.gif'>
<table width='100%' border='0' cellspacing='0' cellpadding='1'>
<tr>
  <td ><b>Tre¶æ wiadomo¶ci</b></td>
</tr>
<tr>
  <td valign='middle' align='center'> <br />
<table width='100' border='0' cellspacing='0' cellpadding='5'>
<tr align='center'>
  <td><b>Emotki</b></td>
</tr>
<tr>
  <td><table cellpadding='4'>$autosmiley</table></td>
</tr>
</table>
  </td>
</tr>
</table>
  </td>
  <td valign='top' background='themes/$theme/gfx/bg2.gif'>
<table border='0' cellspacing='0' cellpadding='2'>
 <tr align='center' valign='middle'>
  <td><input type=\"button\" value=\"b\" style=\"font-weight:bold;\" OnClick=\"javascript:AddText('[b] [/b]')\" onMouseover=\"show_text(0,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"i\" style=\"font-style:italic;\" OnClick=\"javascript:AddText('[i] [/i]')\" onMouseover=\"show_text(1,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"u\" style=\"font-decoration:underline;\" OnClick=\"javascript:AddText('[u] [/u]')\" onMouseover=\"show_text(2,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"img\" OnClick=\"javascript:AddText('[img]http:// [/img]')\" onMouseover=\"show_text(5,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"quote\" OnClick=\"javascript:AddText('[quote] [/quote]')\" onMouseover=\"show_text(7,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"code\" OnClick=\"javascript:AddText('[code] [/code]')\" onMouseover=\"show_text(6,'div1')\" onMouseout=\"resetit('div1')\"></td>
</tr>
<tr>
  <td colspan='9'>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr>
  <td>&nbsp;Kolor: <select onchange='showcolor(this.options[this.selectedIndex].value)' name='txtcolor' onMouseover=\"show_text(8,'div1')\" onMouseout=\"resetit('div1')\">
<option style='background-color: #000000; color: #000000' value=#000000>#000000</option>
<option style='background-color: #ff0000; color: #ff0000' value=#ff0000>#ff0000</option>
<option style='background-color: #990000; color: #990000' value=#990000>#990000</option>
<option style='background-color: #006600; color: #006600' value=#006600>#006600</option>
<option style='background-color: #00ff00; color: #00ff00' value=#00ff00>#00ff00</option>
<option style='background-color: #0000ff; color: #0000ff' value=#0000ff>#0000ff</option>
<option style='background-color: #000099; color: #000099' value=#000099>#000099</option>
<option style='background-color: #ffff00; color: #ffff00' value=#ffff00>#ffff00</option>
<option style='background-color: #ff6600; color: #ff6600' value=#ff6600>#ff6600</option>
<option style='background-color: #00ffff; color: #00ffff' value=#00ffff>#00ffff</option>
<option style='background-color: #ff00ff; color: #ff00ff' value=#ff00ff>#ff00ff</option>
<option style='background-color: #ff99ff; color: #ff99ff' value=#ff99ff>#ff99ff</option>
<option style='background-color: #9900ff; color: #9900ff' value=#9900ff>#9900ff</option>
<option style='background-color: #999999; color: #999999' value=#999999>#999999</option>
<option style='background-color: #c0c0c0; color: #c0c0c0' value=#c0c0c0>#c0c0c0</option>
<option value=#ffffff selected>Wybierz</option>
</select>
  </td>
</tr>
</table>
  </td>
</tr>
<tr>
 <td colspan='9'><table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'><tr><td height='24' align='center' background='themes/$theme/gfx/bg1.gif'>&nbsp;<span id='div1'></span></td></tr></table></td>
</tr>
<tr>
 <td colspan='9'><textarea cols='50' rows='10' name='message' style='width: 307px'>$text</textarea></td>
</tr>
</table>
  </td>
</tr><tr>
  <td colspan='2' align='center' background='themes/$theme/gfx/bg1.gif'><input type='hidden' name='id' value='$id'><input type='submit' name='submit' value=' Wy¶li '></td>
</tr>
</table>";
TableAdmin("Edycja artyku³u","$tresc");
}

function editsf() {
global $ttitle,$message,$id,$folderid,$db_prefix;

if(trim($ttitle) == "")
{
$tresc .= "Wpisz tytu³";
}
elseif(trim($message) == "")
{
$tresc .= "Wpisz tre¶æ";
}
elseif(trim($folderid) == "")
{
$tresc .= "Wybierz Kategoriê";
}
else
{
mysql_query("UPDATE ". $db_prefix ."articles SET `title` = '$ttitle',`text` = '$message',`folder` = '$folderid'  WHERE `id` = '$id'");
$tresc = "Zmiany w artykule zapisano.";

}
TableAdmin("Artyku³y","$tresc");
}

function deletef() {
global  $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."articles WHERE `id` = '$id'");
$tresc = "Artyku³ usuniêto.";

TableAdmin("Artyku³y","$tresc");
}

function add() {
global $db_prefix;
$tresc .= "<table cellspacing='3'><FORM METHOD='POST' ACTION='admin.php?mode=articles&action=adds#bottom'><tr><td>Nazwa kategorii: </td><td><input type='text' name='name' size='25'></td></tr><tr><td>Opis Kategorii: </td><td><TEXTAREA NAME='description' ROWS='4' COLS='35'></TEXTAREA></td></tr><tr><td><INPUT TYPE='submit' VALUE='Dodaj'></td></tr></table></FORM>";
TableAdmin("Dodaj kategoriê","$tresc");
}

function adds() {
global $name,$description,$db_prefix;

mysql_query("INSERT INTO ". $db_prefix ."articles_folders (name,description) VALUES ('$name','$description')");
$tresc = "Kategoriê dodano.";

TableAdmin("Dodaj kategoriê","$tresc");
}

function addf() {
global $theme,$db_prefix;


$result = mysql_query("SELECT * FROM ". $db_prefix ."articles_folders");
$how_filders = mysql_num_rows($result);
if($how_filders == "0")
{
$tresc .= "Utwó¿ kategoriê.";
}
else
{
$smileytd = 1;
$query = mysql_query("SELECT * FROM ". $db_prefix ."smiley ORDER BY sid ASC") or die(mysql_error());
while($smiley = mysql_fetch_array($query)) {
if($smileytd == 1) {
$autosmiley .= "<tr>
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>";
$smileytd = 2;
} elseif($smileytd == 2) {
$autosmiley .= "
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>";
$smileytd = 3;
} elseif($smileytd == 3) {
$autosmiley .= "
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>";
$smileytd = 4;
} elseif($smileytd == 4) {
$autosmiley .= "
  <td><a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a></td>
</tr>";
$smileytd = 1;
}
}

$tresc = "<script language='javascript1.2' src='nb.js' type=text/javascript></script>
<form method='post' action='admin.php?mode=articles&action=addsf#bottom' name='input'>
<table border='0' cellpadding='3' cellspacing='1' width='100%'>
<tr>
  <td width='22%' background='themes/$theme/gfx/bg1.gif'><b>Temat</b></td>
  <td background='themes/$theme/gfx/bg2.gif'><input type='text' name='title' style='width: 307px'>
  </td>
</tr>
<tr>
  <td width='22%' background='themes/$theme/gfx/bg1.gif'><b>Kategoria</b></td>
  <td background='themes/$theme/gfx/bg2.gif'><select name='folderid' style='width: 307px;'>";
$sql = "SELECT * FROM ". $db_prefix ."articles_folders";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$folder_id = $row['id'];
$folder_name = $row['name'];
$tresc .= "<option value='$folder_id'>$folder_name</option>";
}
$tresc .= "</select>
  </td>
</tr>
<tr>
  <td valign='top' background='themes/$theme/gfx/bg1.gif'>
<table width='100%' border='0' cellspacing='0' cellpadding='1'>
<tr>
  <td ><b>Tre¶æ wiadomo¶ci</b></td>
</tr>
<tr>
  <td valign='middle' align='center'> <br />
<table width='100' border='0' cellspacing='0' cellpadding='5'>
<tr align='center'>
  <td><b>Emotki</b></td>
</tr>
<tr>
  <td><table cellpadding='4'>$autosmiley</table></td>
</tr>
</table>
  </td>
</tr>
</table>
  </td>
  <td valign='top' background='themes/$theme/gfx/bg2.gif'>
<table border='0' cellspacing='0' cellpadding='2'>
 <tr align='center' valign='middle'>
  <td><input type=\"button\" value=\"b\" style=\"font-weight:bold;\" OnClick=\"javascript:AddText('[b] [/b]')\" onMouseover=\"show_text(0,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"i\" style=\"font-style:italic;\" OnClick=\"javascript:AddText('[i] [/i]')\" onMouseover=\"show_text(1,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"u\" style=\"font-decoration:underline;\" OnClick=\"javascript:AddText('[u] [/u]')\" onMouseover=\"show_text(2,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"img\" OnClick=\"javascript:AddText('[img]http:// [/img]')\" onMouseover=\"show_text(5,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"quote\" OnClick=\"javascript:AddText('[quote] [/quote]')\" onMouseover=\"show_text(7,'div1')\" onMouseout=\"resetit('div1')\"></td>
  <td><input type=\"button\" value=\"code\" OnClick=\"javascript:AddText('[code] [/code]')\" onMouseover=\"show_text(6,'div1')\" onMouseout=\"resetit('div1')\"></td>
</tr>
<tr>
  <td colspan='9'>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr>
  <td>&nbsp;Kolor: <select onchange='showcolor(this.options[this.selectedIndex].value)' name='txtcolor' onMouseover=\"show_text(8,'div1')\" onMouseout=\"resetit('div1')\">
<option style='background-color: #000000; color: #000000' value=#000000>#000000</option>
<option style='background-color: #ff0000; color: #ff0000' value=#ff0000>#ff0000</option>
<option style='background-color: #990000; color: #990000' value=#990000>#990000</option>
<option style='background-color: #006600; color: #006600' value=#006600>#006600</option>
<option style='background-color: #00ff00; color: #00ff00' value=#00ff00>#00ff00</option>
<option style='background-color: #0000ff; color: #0000ff' value=#0000ff>#0000ff</option>
<option style='background-color: #000099; color: #000099' value=#000099>#000099</option>
<option style='background-color: #ffff00; color: #ffff00' value=#ffff00>#ffff00</option>
<option style='background-color: #ff6600; color: #ff6600' value=#ff6600>#ff6600</option>
<option style='background-color: #00ffff; color: #00ffff' value=#00ffff>#00ffff</option>
<option style='background-color: #ff00ff; color: #ff00ff' value=#ff00ff>#ff00ff</option>
<option style='background-color: #ff99ff; color: #ff99ff' value=#ff99ff>#ff99ff</option>
<option style='background-color: #9900ff; color: #9900ff' value=#9900ff>#9900ff</option>
<option style='background-color: #999999; color: #999999' value=#999999>#999999</option>
<option style='background-color: #c0c0c0; color: #c0c0c0' value=#c0c0c0>#c0c0c0</option>
<option value=#ffffff selected>Wybierz</option>
</select>
  </td>
</tr>
</table>
  </td>
</tr>
<tr>
 <td colspan='9'><table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'><tr><td height='24' align='center' background='themes/$theme/gfx/bg1.gif'>&nbsp;<span id='div1'></span></td></tr></table></td>
</tr>
<tr>
 <td colspan='9'><textarea cols='50' rows='10' name='message' style='width: 307px'></textarea></td>
</tr>
</table>
  </td>
</tr><tr>
  <td colspan='2' align='center' background='themes/$theme/gfx/bg1.gif'><input type='submit' name='submit' value=' Wy¶li '></td>
</tr>";
}
$tresc .= "</table>";
TableAdmin("Dodaj artyku³","$tresc");
}

function addsf() {
global $title,$message,$folderid,$db_prefix;

if(trim($title) == "")
{
$tresc .= "Wpisz tytu³";
}
elseif(trim($message) == "")
{
$tresc .= "Wpisz tre¶æ";
}
elseif(trim($folderid) == "")
{
$tresc .= "Wybierz Kategoriê";
}
else
{
$date = time();
mysql_query("INSERT INTO ". $db_prefix ."articles ( `id` , `title` , `text` , `date` , `folder`) VALUES ('', '$title', '$message', '$date', '$folderid')");
$tresc = "Artyku³ dodano.";
}

TableAdmin("Dodaj artyku³","$tresc");
}
?>
