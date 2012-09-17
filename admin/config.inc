<?
include "config.php";
function nothing() {
global $db_prefix;
$tresc = "<form method='post' action='admin.php?mode=config&action=save#bottom'><table border='0' width='100%' cellpadding='4' cellspacing='0'>";
$query = mysql_query("SELECT * FROM ". $db_prefix ."config");
while($config=mysql_fetch_array($query)){
$owner = $config['owner'];
$sitename = $config['sitename'];
$theme = $config['theme'];
$nlimit = $config['nlimit'];
$adminemail = $config['adminemail'];
$siteadress = $config['siteadress'];
$adminpass = $config['adminpass'];
$maxtop = $config['maxtop'];
$maxrep = $config['maxrep'];
$avatar_width = $config['avatar_width'];
$avatar_height = $config['avatar_height'];
$guests_download_files = $config['guests_download_files'];
$stats = $config['stats'];
$comments = $config['comments'];
$pool = $config['pool'];
$tresc .= "<tr><td>Admin strony:</td><td><input type='text' name='owner2' value='$owner'></td></tr>
<tr><td>Em@il admina:</td><td><input type='text' name='adminemail2' value='$adminemail'></td></tr>
<tr><td>Nazwa strony:</td><td><input type='text' name='sitename2' value='$sitename'></td></tr>
<tr><td>Domy¶lny skin:</td><td><select name='theme2'>";
$dir = opendir("themes/");
while($r = readdir($dir)) {
if($r<>'.' AND $r<>'..' AND is_dir('themes/'.$r)) {
if($r==$config['theme']) {
$sel = ' selected';
} else {
$sel ='';
}
$v = $r;
$tresc .=  '<option value="'.$v.'"'.$sel.'>'.$r.'</option>';
}
}

if($guests_download_files == "1"){
$sel_g = ' selected';
}else{
$sel_gg = ' selected';
}

if($stats == "1"){
$sel_s = ' selected';
}else{
$sel_ss = ' selected';
}

if($comments == "1"){
$com_s = ' selected';
}else{
$com_ss = ' selected';
}

if($pool == "1"){
$vote_s = ' selected';
}else{
$vote_ss = ' selected';
}

$tresc .= "</select></td></tr>
<tr><td>Limit newsów na stronie g³ównej:</td><td><input type='text' name='nlimit2' value='$nlimit'></td></tr>
<tr><td>Limit tematów na 1 stronie forum:</td><td><input type='text' name='maxtop' value='$maxtop'></td></tr>
<tr><td>Limit odpowiedzi na 1 stronie forum:</td><td><input type='text' name='maxrep' value='$maxrep'></td></tr>
<tr><td>Niezarejestrowani mog± ¶ci±gaæ pliki:</td><td><select name='g_d_f'><option value='1'$sel_g>TAK</option><option value='0'$sel_gg>NIE</option></td></tr>
<tr><td>Niezarejestrowani mog± pisaæ komentarze:</td><td><select name='com_g'><option value='1'$com_s>TAK</option><option value='0'$com_ss>NIE</option></td></tr>
<tr><td>Niezarejestrowani mog± g³osowaæ:</td><td><select name='vote_g'><option value='1'$vote_s>TAK</option><option value='0'$vote_ss>NIE</option></td></tr>
<tr><td>Statystyki widoczna dla wszystkich:</td><td><select name='stats_x'><option value='1'$sel_s>TAK</option><option value='0'$sel_ss>NIE</option></td></tr>
<tr><td>Max wysoko¶æ Awatara:</td><td><input type='text' name='av_height' value='$avatar_height'></td></tr>
<tr><td>Max szeroko¶æ Awatara:</td><td><input type='text' name='av_width' value='$avatar_width'></td></tr>
<tr><td>Adres strony (bez '/' na koñcu):</td><td><input type='text' name='siteadress2' value='$siteadress'></td></tr>
<tr><td><input type='submit' value='Zapisz'></TD></TR>";
}
$tresc .= "</table></form>";

TableAdmin("Konfiguracja",$tresc);
}

function save() {
global $owner2, $sitename2, $theme2, $nlimit2, $adminemail2, $siteadress2, $maxtop, $maxrep, $av_height, $av_width, $g_d_f, $stats_x, $com_g, $vote_g, $db_prefix;
mysql_query("DELETE FROM ". $db_prefix ."config");
mysql_query("INSERT INTO ". $db_prefix ."config (owner, sitename, theme, nlimit, adminemail, siteadress, maxtop, maxrep, avatar_width, avatar_height, guests_download_files, stats, comments, pool) VALUES ('$owner2', '$sitename2', '$theme2', '$nlimit2', '$adminemail2', '$siteadress2', '$maxtop', '$maxrep', '$av_width', '$av_height', '$g_d_f', '$stats_x', '$com_g', '$vote_g');");
$tresc .= "Ustawienia zmieniono";

TableAdmin("Konfiguracja",$tresc);
}
?>
