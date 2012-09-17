<?
include "config.php";
function nothing() {
global $theme,$db_prefix;
$tresc .= "</center><b>Online na stronie:</B><br>";
$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online WHERE name='guest'") or die(mysql_error());
$onlineg = mysql_result($query, 0);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online WHERE name!='guest'") or die(mysql_error());
$onlineu = mysql_result($query, 0);

$tresc .= "<table width='100%' cellpadding='2' cellspacing='1' border='0'><tr><td width='25%'  background='themes/$theme/gfx/titlebg.gif'>U¿ytkowników: $onlineu Go¶ci: $onlineg</td><td width='25%' background='themes/$theme/gfx/titlebg.gif'><b>Ostatnia aktywno¶æ</B></td><td width='30%'  background='themes/$theme/gfx/titlebg.gif'><b>Lokacja</b></td><td width='20%'  background='themes/$theme/gfx/titlebg.gif'><b>IP</b></td></tr>";
$ttnum = 1;
$query = mysql_query("SELECT * FROM ". $db_prefix ."online WHERE name!='guest'");
while($onl = mysql_fetch_array($query)) {

$user_id = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username = '$onl[name]'"));

$tresc .= "<tr><td width='25%' background='themes/$theme/gfx/bg$ttnum.gif'><a href='member.php?action=viewpro&member=$user_id[uid]'>$onl[name]</a></td><td width='25%' background='themes/$theme/gfx/bg$ttnum.gif'>" . datepl(date("d-m-Y H:i", $onl[time])). "</td><td width='30%'  background='themes/$theme/gfx/bg$ttnum.gif'>$onl[site]</td><td width='20%' background='themes/$theme/gfx/bg$ttnum.gif'><a href='http://ripe.net/perl/whois?form_type=simple&full_query_string=&searchtext=$onl[ip]' target='_blank'>$onl[ip]</a></td></tr>";
$ttnum = altcolors($ttnum);
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."online WHERE name='guest'");
while($onl = mysql_fetch_array($query)) {
$tresc .= "<tr><td width='25%' background='themes/$theme/gfx/bg$ttnum.gif'>Go¶æ</td><td width='25%' background='themes/$theme/gfx/bg$ttnum.gif'>" . datepl(date("d-m-Y H:i", $onl[time])). "</td><td width='30%'  background='themes/$theme/gfx/bg$ttnum.gif'>$onl[site]</td><td width='20%' background='themes/$theme/gfx/bg$ttnum.gif'><a href='http://ripe.net/perl/whois?form_type=simple&full_query_string=&searchtext=$onl[ip]' target='_blank'>$onl[ip]</a></td></tr>";
$ttnum = altcolors($ttnum);
}

$tresc .= "</table><br>";
$tresc .= "<b>Statystyki:</b><br>";
$tresc .= "<table width='100%' cellpadding='2' cellspacing='1' border='0'><tr><td width='70%'  background='themes/$theme/gfx/titlebg.gif'><b>Nazwa</B></td><td width='20%' background='themes/$theme/gfx/titlebg.gif'><b>Ilo¶æ</B></td></tr>";
$ttnum = 1;

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."articles");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Artyku³ów:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);


$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."banners");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Bannerów:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."files");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Plików:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."files_broken");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Zg³oszenia o b³êdnych plikach:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."guest_book");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Wpisów w ksiêdze go¶ci:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."member");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>U¿ytkowników:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."news");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Newsów:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."page");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Stron informacyjnych:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."post");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Postów na forum:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."topic");
$result = mysql_result($query, 0);
$tresc .= "<tr><td background='themes/$theme/gfx/bg$ttnum.gif'>Tematów na forum:</td><td background='themes/$theme/gfx/bg$ttnum.gif'>$result</td></tr>";
$ttnum = altcolors($ttnum);

$tresc .= "</table>";
TableAdmin("Witaj",$tresc);
}
?>
