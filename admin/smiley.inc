<?
include "config.php";
if(!$action) {
$tresc = "<table border='0' cellpadding='4' cellspacing='0' width='100%'><tr><td width='100%'>Emotki musz± byæ umieszczone w folderze image/smiles/ .<br>W kodzie nie wskazane jest u¿ywanie znaków \" ' ></td></tr></table><table border='0' cellpadding='0' cellspacing='0' width='100%'></table><table border='0' cellpadding='4' cellspacing='0' width='75%' align='center'><form method='post' action='admin.php?mode=smiley&action=save#bottom'><tr><td width='10%' align='center'>Kasuj</td><td width='40%' align='center'>Nazwa</td><td width='40%' align='center'>Kod</td><td width='10%' align='center'>Podgl±d</td></tr>";
$ttnum = 1;
$query = mysql_query("SELECT * FROM ". $db_prefix ."smiley");
while($smiley = mysql_fetch_array($query)) {
$tresc .= "<tr><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'><input type='checkbox' name='delete$smiley[sid]' value='$smiley[sid]'></td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'><input type='text' name='url$smiley[sid]' value='$smiley[url]' size='30'></td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'><input type='text' name='code$smiley[sid]' value='$smiley[code]' size='30' ></td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'><img src='image/smiles/$smiley[url]'></td></tr>";
$ttnum = altcolors($ttnum);
}

$tresc .= "<tr><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td></tr>";
$ttnum = altcolors($ttnum);
$tresc .= "<tr><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'><b>Dodaj now± emotkê.</b></td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td></tr>";
$ttnum = altcolors($ttnum);
$tresc .= "<tr><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>";
$tresc .= "<select onchange=\"update_smiley(this.options[selectedIndex].value);\" name=\"newurl\">\r\n";
$dir = opendir("image/smiles/");
while($r = readdir($dir)) {
if($r<>'.' AND $r<>'..' AND $r<>'index.php' ) {
$tresc .= "<option value=\"$r\">$r</option>\r\n";
}
}
$tresc .= "</select><img src=\"image/smiles/sad.gif\" border=\"0\" name=\"smiley_image\"></td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'><input type='text' name='newcode' size='30' ></td><td align='center' background='themes/$theme/gfx/bg$ttnum.gif'>&nbsp;</td></tr>";

$tresc .= "</table><center ><input type='submit' name='submit' value=' Zapisz '></center></form>";


TableAdmin("Emotikonki",$tresc);


} else {

$query = mysql_query("SELECT sid FROM ". $db_prefix ."smiley") or die(mysql_error());
while($smiley = mysql_fetch_array($query)) {
$url = "url$smiley[sid]";
$url = "${$url}";
$code = "code$smiley[sid]";
$code = "${$code}";
$delete = "delete$smiley[sid]";
$delete = "${$delete}";

if($delete != "") {
mysql_query("DELETE FROM ". $db_prefix ."smiley WHERE sid='$delete'") or die(mysql_error());
}


mysql_query("UPDATE ". $db_prefix ."smiley SET url='$url', code='$code' WHERE sid='$smiley[sid]'") or die(mysql_error());
}

if($newcode != "") {
mysql_query("INSERT INTO ". $db_prefix ."smiley VALUES ('', '$newurl', '$newcode')") or die(mysql_error());
}
$tresc = "Zapisano.";

TableAdmin("Emotikonki",$tresc);
}
?>
