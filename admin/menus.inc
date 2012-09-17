<?
include "config.php";
function nothing() {
global $theme,$db_prefix;
$queryl = mysql_query("SELECT * FROM ". $db_prefix ."menu WHERE side='left' ORDER BY `order` ASC");
$tresc = "<font size='4'>* Lewa strona</font><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='3%'>Lp</td><td width='70%'>Nazwa</td><td align='center' width='10%'>Przenie¶</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";
$l = 1;
while($menul=mysql_fetch_array($queryl)){
$tresc .= "<tr><td>" .  $l++ .  ".</td><td>" . $menul['title'] . "</td><td align='center'><a href='admin.php?mode=menus&action=move&id=" . $menul['id'] . "&side=right#bottom'><img src='themes/$theme/gfx/right.gif' border='0' alt='w prawo' title='w prawo'></a> <a href='admin.php?mode=menus&action=move&id=" . $menul['id'] . "&side=up#bottom'><img src='themes/$theme/gfx/up.gif' border='0' alt='w górê' title='w górê'></a> <a href='admin.php?mode=menus&action=move&id=" . $menul['id'] . "&side=down#bottom'><img src='themes/$theme/gfx/down.gif' border='0' alt='w dó³' title='w dó³'></a></td><td align='center'><a href='admin.php?mode=menus&action=edit&id=" . $menul['id'] . "#bottom'>E</a><td align='center'><a href='admin.php?mode=menus&action=delete&id=" . $menul['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .="</table><bR><hr><br>";

$queryr = mysql_query("SELECT * FROM ". $db_prefix ."menu WHERE side='right' ORDER BY `order` ASC");
$tresc .= "<font size='4'>* Prawa strona</font><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='3%'>Lp</td><td width='70%'>Nazwa</td><td align='center' width='10%'>Przenie¶</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";
$r = 1;
while($menur=mysql_fetch_array($queryr)){
$tresc .= "<tr><td>" .  $r++ .  ".</td><td>" . $menur['title'] . "</td><td align='center'><a href='admin.php?mode=menus&action=move&id=" . $menur['id'] . "&side=left#bottom' ><img src='themes/$theme/gfx/left.gif' border='0' alt='w lewo' title='w lewo'></a> <a href='admin.php?mode=menus&action=move&id=" . $menur['id'] . "&side=up#bottom'><img src='themes/$theme/gfx/up.gif' border='0' alt='w górê' title='w górê'></a> <a href='admin.php?mode=menus&action=move&id=" . $menur['id'] . "&side=down#bottom'><img src='themes/$theme/gfx/down.gif' border='0' alt='w dó³' title='w dó³'></a></td><td align='center'><a href='admin.php?mode=menus&action=edit&id=" . $menur['id'] . "#bottom'>E</a><td align='center'><a href='admin.php?mode=menus&action=delete&id=" . $menur['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .="</table>";

TableAdmin("Bloki menu","$tresc");
}

function move() {
global $side,$id,$db_prefix;

if($side == "left")
{
mysql_query("UPDATE ". $db_prefix ."menu SET `side` = 'left' WHERE `id` = '$id' LIMIT 1");
}

elseif($side == "right")
{
mysql_query("UPDATE ". $db_prefix ."menu SET `side` = 'right' WHERE `id` = '$id' LIMIT 1");
}

elseif($side == "down")
{
$query = mysql_query("SELECT * FROM ". $db_prefix ."menu WHERE id='$id'");
while($menu=mysql_fetch_array($query))
{
$order = $menu['order'];
$norder = $order + 1;
mysql_query("UPDATE `menu` SET `order` = '$norder' WHERE `id` = '$id'");
}
}

elseif($side == "up")
{
$query = mysql_query("SELECT * FROM ". $db_prefix ."menu WHERE id='$id'");
while($menu=mysql_fetch_array($query)){
$order = $menu['order'];
$norder = $order - 1;
mysql_query("UPDATE ". $db_prefix ."menu SET `order` = '$norder' WHERE `id` = '$id'");
}
}
$tresc = "Menu przeniesiono.";


TableAdmin("Bloki menu","$tresc");
}

function edit() {
global $id,$db_prefix;

$query = mysql_query("SELECT * FROM ". $db_prefix ."menu where id='$id'");
while($menu=mysql_fetch_array($query)){
$text = $menu['text'];
$title = $menu['title'];
}
$tresc = "
<form method='post' action='admin.php?mode=menus&action=edits#bottom'>
 <table border='0' cellpadding='1' cellspacing='0' width='100%'>
  <tr>
   <td>Tytu³:</td>
   <td><input type='text' name='block_edit_title' value='$title' size='15'></td>
  </tr>
  <tr>
   <td valign='top'>Tre¶æ:</td>
   <td><textarea cols='65' rows='10' name='block_edit_text'>$text</textarea></td>
  </tr>
  <tr>
   <td><input type='submit' value='Wy¶li'><input type='hidden' name='id' value='$id'></td>
  </tr>
 </table>
</form>";

TableAdmin("Bloki menu","$tresc");
}

function edits() {
global $id,$block_edit_title,$block_edit_text,$db_prefix;

mysql_query("UPDATE ". $db_prefix ."menu SET `title` = '$block_edit_title',`text` = '$block_edit_text' WHERE `id` = '$id' LIMIT 1");
$tresc = "Zmiany w menu zapisano.";

TableAdmin("Bloki menu","$tresc");
}

function delete() {
global $id;

mysql_query("DELETE FROM ". $db_prefix ."menu WHERE id='$id'");
$tresc = "Menu usuniêto.";

TableAdmin("Bloki menu","$tresc");
}

function add() {

$tresc = "Je¶li chcesz dodaæ blok specjalny to postêpuj wg. schematu: wpisanie w Tre¶ci '||a||' (bez ' i ') spowoduje wgranie w ten blok pliku blocks/a.inc .
<form method='post' action='admin.php?mode=menus&action=adds#bottom'>
 <table border='0' cellpadding='1' cellspacing='0' width='100%'>
  <tr>
   <td>Tytu³:</td>
   <td><input type='text' name='blick_title' value='' size='15'></td>
  </tr>
  <tr>
   <td>Strona:</td>
   <td><select name='side'><option value='left'>lewa</option><option value='right'>prawa</option></select></td>
  </tr>
  <tr>
   <td valign='top'>Tre¶æ:</td>
   <td><textarea cols='65' rows='10' name='blick_text'></textarea></td>
  </tr>
  <tr>
   <td><input type='submit' value='Wy¶li'></td>
  </tr>
 </table>
</form>";

TableAdmin("Dodaj blok menu","$tresc");
}

function adds() {
global $blick_title,$blick_text,$side,$db_prefix;

mysql_query("INSERT INTO ". $db_prefix ."menu ( `id` , `title` , `text` , `side` ) VALUES ('', '$blick_title', '$blick_text', '$side')");
$tresc = "Blok menu dodano.";

TableAdmin("Dodaj blok menu","$tresc");
}
?>
