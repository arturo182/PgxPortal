<?
/*
*****************************************************
*    PgxPortal by arturo182<arturo182@tlen.pl>      *
*****************************************************
* SKRYPT CHRONIONY PRZEZ BOWI Group                 *
* Biuro Ochrony Witryn Internetowych                *
* www.bowi.org.pl                                   *
* biuro@bowi.org.pl                                 *
*****************************************************
*/
include "config.php";
extract($_SERVER);

  $nazwa_pliku = array();
  $nazwa_pliku = explode("/",$SCRIPT_NAME);
  $nazwa_pliku = array_reverse($nazwa_pliku);
  $nazwa_pliku = $nazwa_pliku[0];
  
  if(!eregi($nazwa_pliku, "admin.php"))

{
if(!$action) {
$query = mysql_query("SELECT * FROM ". $db_prefix ."banners WHERE enable='1' ORDER BY RAND() LIMIT 1");
while($banner=mysql_fetch_array($query)) {
$id = $banner['id'];
$code = $banner['code'];
$views = $banner['views'];
$image = $banner['image'];
$type = $banner['type'];
$width = $banner['width'];
$height = $banner['height'];
$max_views = $banner['max_views'];


if($max_views != "0")
{
 if($max_views == $views)
 {
  mysql_query("UPDATE ". $db_prefix ."banners SET enable='0' WHERE id='$id'");
 }
}

if($max_views != $views)
{
$nviews = $views+1;
}

mysql_query("UPDATE ". $db_prefix ."banners SET views=$nviews WHERE id='$id'");
if($type == "2")
{
echo "$code";
}
else
{
echo '<a href="banners.php?action=click&id='.$id.'" target="_blank"><img src="'.$image.'" border="0" width="'. $width .'" height="'. $height .'"></a>';
}
}
}
if($action == "click")
{
include "config.php";
$query = mysql_query("SELECT * FROM ". $db_prefix ."banners WHERE id=$id");
$banner=mysql_fetch_array($query);
$clicks = $banner['clicks'];
$link = $banner['link'];
$enable = $banner['enable'];

if($enable != "0")
{
$xclicks= $clicks+1;
mysql_query("UPDATE ". $db_prefix ."banners SET clicks=$xclicks WHERE id='$id'");
header("Location: $link");
exit;
}
else
{
header("Location: index.php");
exit;
}
}
if($action == "show") {
include "config.php";
$site = "Bannery";
include "include.php";
include "themes/$theme/theme.php";
openSite("Bannery");
MenuLeft();
$tresc .= "
<center>
  ";
  $query = mysql_query("SELECT * FROM ". $db_prefix ."banners WHERE enable='1'");
  if(mysql_num_rows($query) == 0){
  $tresc .= '
  <center>
    <b>Brak bannerów.</b>
  </center>
  ';
  } else {
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
  if($type == "2") {
  $tresc .= $code.'<bR>Wy¶wietleñ: <b>'.$views.'</b> Klikniêæ: <b>-</B><br><br>';
  } else {
  $tresc .= '<a href="banners.php?action=click&id='.$id.'"><img src="'.$image.'" border="0" width="'. $width .'" height="'. $height .'"></a><br>Wy¶wietleñ: <b>'.$views.'</b> Klikniêæ: <b>'.$clicks.'</B><br><br>';
  }
  }
  }
  openTableMini("Bannery",$tresc);
  closeTableMini();
  closeSite();
  }
  }
?>
