<?
include "config.php";
echo '<center><form><select name="stheme" onchange="this.form.submit()">';

$dir = opendir("themes");

while($r = readdir($dir)) {

if($r<>'.' AND $r<>'..' AND is_dir('themes/'.$r)) {

$query = mysql_query("SELECT * FROM ". $db_prefix ."config");
$config=mysql_fetch_array($query);

if(!$_COOKIE['pgxtheme'])
{
$theme = $config['theme'];
}
else
{
$theme = $_COOKIE['pgxtheme'];
}

if($r==$theme)
{
$sel = ' selected';
}
else
{
$sel ='';
}

$v = $r;

echo '<option value="'.$v.'"'.$sel.'>'.$r.'</option>';

}
}

echo '</select></form></center>';
?>
