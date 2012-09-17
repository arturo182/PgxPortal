<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."news ORDER BY id ASC");
$how_news = mysql_num_rows($query);
if($how_news == "0")
{
$tresc = "Brak newsów";
}
else
{
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='50%'>Nazwa</td><td width='25%' align='center'>Data</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td><td width='10%' align='center'>Kom.</td></tr>";

while($article=mysql_fetch_array($query)){
$tresc .= "<tr><td>" . $article['id'] . "</td><td>" . $article['title'] . "</a></td><td>" .datepl(date("d-m-Y H:i", $article['date'])) . "</td><td align='center'><a href='admin.php?mode=news&action=edit&id=" . $article['id'] . "#bottom'>E</a><td  align='center'><a href='admin.php?mode=news&action=delete&id=" . $article['id'] . "#bottom'>U</a><td  align='center'><a href='admin.php?mode=news&action=comments&id=" . $article['id'] . "#bottom'>K</a></td></tr>";
}
$tresc .="</table>";
}
TableAdmin("Newsy","$tresc");
}

function edit() {
global $id,$theme,$db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."news where id='$id'");
while($article=mysql_fetch_array($query)){
$text = $article['text'];
$title = $article['title'];
}

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
<form method='post' action='admin.php?mode=news&action=edits#bottom'>
<table border='0' cellpadding='3' cellspacing='1' width='100%'>
<tr>
  <td width='22%' background='themes/$theme/gfx/bg1.gif'><b>Temat</b></td>
  <td background='themes/$theme/gfx/bg2.gif'><input type='text' name='edit_news_title' style='width: 307px' value='$title'>
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
 <td colspan='9'><textarea cols='50' rows='10' name='edit_news_message' style='width: 307px'>$text</textarea></td>
</tr>
</table>
  </td>
</tr><tr>
  <td colspan='2' align='center' background='themes/$theme/gfx/bg1.gif'><input type='hidden' name='edit_news_id' value='$id'><input type='submit' name='submit' value=' Wy¶li '></td>
</tr>
</table>";

TableAdmin("Newsy","$tresc");
}

function edits() {
global $edit_news_title, $edit_news_message, $edit_news_id,$db_prefix;
mysql_query("UPDATE ". $db_prefix ."news SET `title` = '$edit_news_title',`text` = '$edit_news_message' WHERE `id` = '$edit_news_id' LIMIT 1");
$tresc = "Zmiany w newsie zapisano.";

TableAdmin("Newsy","$tresc");
}

function delete() {
global $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."news WHERE `id` = '$id'");
$tresc = "Newsa usuniêto.";

TableAdmin("Newsy","$tresc");
}

function comments() {
global $id,$db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."news_comments WHERE newsid='$id' ORDER BY date DESC");
$how_comments = mysql_num_rows($query);
if($how_comments == "0")
{
$tresc = "Nie ma jeszcze ¿adnych komenatarzy do tego newsa";
}
else
{
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='40%'>Tre¶æ</td><td width='15%'>Autor</td><td width='25%'>Data</td><td width='5%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
$tresc .= "<tr><td>" .  shorter($row['text'],40) . "</td><td>" . $row['author'] . "</td><td>" .datepl(date("d-m-Y H:i", $row['date'])) . "</td><td align='center'><a href='admin.php?mode=news&action=deletec&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .= "</table>";
}
TableAdmin("Komentarze","$tresc");
}

function deletec() {
global $id,$db_prefix;
mysql_query("DELETE FROM ". $db_prefix ."news_comments WHERE id='$id'");
$tresc = "Komentarz usuniêto.";

TableAdmin("Komentarze","$tresc");
}

function add() {
global $theme,$db_prefix;
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
<form method='post' action='admin.php?mode=news&action=adds#bottom'>
<table border='0' cellpadding='3' cellspacing='1' width='100%'>
<tr>
  <td width='22%' background='themes/$theme/gfx/bg1.gif'><b>Temat</b></td>
  <td background='themes/$theme/gfx/bg2.gif'><input type='text' name='add_news_title' style='width: 307px'>
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
 <td colspan='9'><textarea cols='50' rows='10' name='add_news_message' style='width: 307px'></textarea></td>
</tr>
</table>
  </td>
</tr><tr>
  <td colspan='2' align='center' background='themes/$theme/gfx/bg1.gif'><input type='submit' name='submit' value=' Wy¶li '></td>
</tr>
</table>";
TableAdmin("Dodaj newsa","$tresc");
}

function adds() {
global $add_news_title,$add_news_message,$pgxuser,$db_prefix;
$date = time();

$user_id = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username = '$pgxuser'"));

mysql_query("INSERT INTO ". $db_prefix ."news ( `id` , `title` , `text` , `date`,  `author`) VALUES ('', '$add_news_title', '$add_news_message', '$date', '$user_id[uid]')");
$tresc = "Newsa dodano.";

TableAdmin("Dodaj newsa.","$tresc");
}
?>
