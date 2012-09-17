<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."banners");
$how_banners = mysql_num_rows($query);
if($how_banners == "0")
{
$tresc .= "Brak bannerów";
}
else
{
while($banner=mysql_fetch_array($query)){
$id = $banner['id'];
$code = $banner['code'];
$clicks = $banner['clicks'];
$views = $banner['views'];
$link = $banner['link'];
$image = $banner['image'];
$type = $banner['type'];

$width = $banner['width'];
$height = $banner['height'];
$max_views = $banner['max_views'];
$enable = $banner['enable'];

if($enable == "1")
{
$enable = "TAK";
}
else
{
$enable = "NIE";
}

$how_end = $max_views - $views;


if($max_views == "0")
{
$ram = "
 <tr>
  <td align='center'>MAX Wy¶wietleñ <b>Nielimitowane</b></td>
 </tr>
";
}
else
{
$ram = "
 <tr>
  <td align='center'>MAX Wy¶wietleñ <b>$max_views</b> | Pozosta³o: <b>$how_end</b></td>
 </tr>
";
}



if($type == "2")
{
$tresc .= "
<table align='center' width='100%'>
<tr>
  <td align='center'>ID: <b>$id</b> | W³±czony: <b>$enable</b></td>
 </tr>
 <tr>
  <td align='center'><a href='admin.php?mode=banners&action=edit&id=" . $id . "#bottom'>Edytuj</a> | <a href='admin.php?mode=banners&action=delete&id=" . $banner['id'] . "#bottom'>Usuñ</a></td>
 </tr>
 <tr>
  <td align='center'>&nbsp;</td>
 </tr>
 <tr>
  <td align='center'>$code</a></td>
 </tr>
 <tr>
  <td align='center'>&nbsp;</td>
 </tr>
 <tr>
  <td align='center'>Wy¶wietleñ <b>$views</b> | Klikniêæ <b>-</b></td>
 </tr>
$ram
 <tr>
  <td align='center'><a href='admin.php?mode=banners&action=reset_stats&id=$id#bottom'>Reset Statsystyk, W³±cz baner</a></td>
 </tr>
</table><br><br><br><br>
";
} else {
$tresc .= "
<table align='center' width='100%'>
<tr>
  <td align='center'>ID: <b>$id</b> | W³±czony: <b>$enable</b></td>
 </tr>
 <tr>
  <td align='center'><a href='admin.php?mode=banners&action=edit&id=" . $id . "#bottom'>Edytuj</a> | <a href='admin.php?mode=banners&action=delete&id=" . $banner['id'] . "#bottom'>Usuñ</a></td>
 </tr>
 <tr>
  <td align='center'>&nbsp;</td>
 </tr>
 <tr>
  <td align='center'><a target='_blank' href='$link'><img src='$image' border='0' width='$width' height='$height' border='0'></a></td>
 </tr>
 <tr>
  <td align='center'>&nbsp;</td>
 </tr>
 <tr>
  <td align='center'>Wy¶wietleñ <b>$views</b> | Klikniêæ <b>$clicks</b></td>
 </tr>
$ram
 <tr>
  <td align='center'><a href='admin.php?mode=banners&action=reset_stats&id=$id#bottom'>Reset Statsystyk, W³±cz baner</a></td>
 </tr>
</table><br><br><br><br>";
}
}
}

TableAdmin("Bannery",$tresc);
}

function edit() {
global $id,$db_prefix;

$banner_query = mysql_query("SELECT * FROM ". $db_prefix ."banners where id='$id'");
$banner = mysql_fetch_array($banner_query);

$banner_link = $banner['link'];
$banner_image = $banner['image'];
$banner_width = $banner['width'];
$banner_height = $banner['height'];
$banner_max_view = $banner['max_views'];
$banner_code = $banner['code'];
$banner_type = $banner['type'];

$banner_width = $banner['width'];
$banner_height = $banner['height'];

$banner_enable = $banner['enable'];
$banner_max_views = $banner['max_views'];


if($banner_type == "1")
{
$sel1 = "selected";
}
else
{
$sel2 = "selected";
}

if($banner_enable == "1")
{
$selx1 = "selected";
}
else
{
$selx2 = "selected";
}

$tresc = "
<form action='admin.php?mode=banners&action=edits#bottom' method='post'>
 <table border='0' cellpadding='3' cellspacing='0' width='100%'>
  <tr>
   <td>Link (pamiêtaj o 'http://'):</td><td><input type='text' name='n_link' value='$banner_link' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Obrazek:</td>
   <td><input type='text' name='n_image' value='$banner_image' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Szeroko¶æ:</td>
   <td><input type='text' name='n_width' value='$banner_width' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Wysoko¶æ:</td>
   <td><input type='text' name='n_height' value='$banner_height' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>MAX Wy¶wietleñ:</td>
   <td><input type='text' name='n_max_views' value='$banner_max_views' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Kod HTML (flash):</td>
   <td><textarea name='n_code' style='width: 316px; height: 100px'>$banner_code</textarea></td>
  </tr>
  <tr>
   <td valign='top'>Typ:</td>
   <td><select name='n_type' style='width: 316px'><option value='1' $sel1 >Obrazek</option><option value='2' $sel2>Flash</option></select></td>
  </tr>
  <tr>
   <td valign='top'>W³±czony:</td>
   <td><select name='n_enable' style='width: 316px'><option value='0' $selx2>NIE</option><option value='1' $selx1>TAK</option></select></td>
  </tr>
  <tr>
   <td><input type='hidden' name='id' value='$id'><input type='submit' value='Wy¶li'></td>
  </tr>
 </table>
</form>";

TableAdmin("Bannery",$tresc);
}

function edits() {
global $id, $n_link, $n_image, $n_type, $n_code,$n_enable,$n_width,$n_height,$n_max_views,$db_prefix;

mysql_query("UPDATE ". $db_prefix ."banners SET `link` = '$n_link',`image` = '$n_image', `type` = '$n_type',`code` = '$n_code',`width` = '$n_width',`height` = '$n_height',`enable` = '$n_enable',`max_views` = '$n_max_views' WHERE `id` = '$id'");
$tresc = "Banner zapisano.";

TableAdmin("Bannery",$tresc);

redirectit("admin.php?mode=banners#bottom");
}

function delete() {
global $id;
mysql_query("DELETE FROM ". $db_prefix ."banners WHERE `id` = '$id'");
$tresc = "Banner usuniêto.";

TableAdmin("Bannery","$tresc");
}

function add() {
global $db_prefix;
$tresc = "Je¿eli chcesz zamie¶ciæ banner, który jest obrazkiem, wybierz typ 'obrazek' i wype³nij pola 'link' i 'obrazek'. Je¿eli banner jest animacj± Flash, wybierz typ 'flash' i wype³nij pole 'kod html'. <b>Bannerom, które sa animacj± Flash nie s± liczone klikniêcia</b>

<form method='post' action='admin.php?mode=banners&action=adds#bottom'>
 <table border='0' cellpadding='3' cellspacing='0' width='100%'>
  <tr>
   <td>Link (pamietaj o 'http://'):</td>
   <td><input type='text' name='add_link' value='' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Obrazek:</td>
   <td><input type='text' name='add_image' value='' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Szeroko¶æ:</td>
   <td><input type='text' name='add_width' value='' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Wysoko¶æ:</td>
   <td><input type='text' name='add_height' value='' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>MAX Wy¶wietleñ:</td>
   <td><input type='text' name='add_max_views' value='' size='60'></td>
  </tr>
  <tr>
   <td valign='top'>Kod HTML:</td>
   <td><textarea name='add_code' style='width: 316px; height: 60px'></textarea></td>
  </tr>
  <tr>
   <td valign='top'>Typ:</td><td><select name='add_type' style='width: 316px'><option value='1'>Obrazek</option><option value='2'>Flash</option></select></td>
  </tr>
  <tr>
   <td colspan='2' align='center'><input type='submit' value='Wy¶li'></td>
  </tr>
 </table>
</form>";

TableAdmin("Dodaj banner","$tresc");
}

function adds(){
global $add_link,$add_image,$add_code,$add_type,$add_width,$add_height,$add_max_views,$db_prefix;

mysql_query("INSERT INTO ". $db_prefix ."banners (`id`, `code`, `views`, `clicks`, `link`, `image`, `type`, `width`, `height`, `max_views`, `enable`) VALUES ('NULL', '$add_code', '0', '0', '$add_link', '$add_image', '$add_type', '$add_width', '$add_height', '$add_max_views', '1')") or die(mysql_error());

$tresc = "Banner dodano.";

TableAdmin("Bannery",$tresc);

redirectit("admin.php?mode=banners#bottom");
}

function reset_stats()
{
global $id,$db_prefix;

mysql_query("UPDATE ". $db_prefix ."banners SET `views` = '0', `clicks` = '0', `enable` = '1' WHERE `id` = '$id'");
$tresc = "Statystyki Zresetowano i banner uaktywniono.";

TableAdmin("Bannery",$tresc);

redirectit("admin.php?mode=banners#bottom");

}
?>
