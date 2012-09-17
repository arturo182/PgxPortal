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

function shorter($tekst, $il_znakow)
{
  if (strlen($tekst) > $il_znakow)
    return substr($tekst, 0, strrpos(substr($tekst, 0, $il_znakow), " ")).'...';
  else return $tekst;
}

function stheme($stheme) {
if(file_exists("themes/$stheme")) {
setcookie("pgxtheme", $stheme);
header("Location: index.php");
}
}

function redirectit($file) {
echo "
<script>
 function redirect() {
 window.location.replace('$file');
}
 setTimeout('redirect();', 2000);
</script>
";
}

function shout($m) {
$mi = explode("-", $m);
        if ($mi[1] == 0) {$m = "Nie " . $mi[2];}
        if ($mi[1] == 1) {$m = "Pon " . $mi[2];}
        if ($mi[1] == 2) {$m = "Wto " . $mi[2];}
        if ($mi[1] == 3) {$m = "¦ro " . $mi[2];}
        if ($mi[1] == 4) {$m = "Czw " . $mi[2];}
        if ($mi[1] == 5) {$m = "Pi± " . $mi[2];}
        if ($mi[1] == 6) {$m = "Sob " . $mi[2];}

        return $m ;
}

function fastredirect($file) {
echo "
<script>window.location.replace('$file');</script>
";
}

function MenuLeft() {
global $db_prefix;
openLeftMenu();
$queryl = mysql_query("SELECT * FROM ". $db_prefix ."menu WHERE side='left' ORDER BY `order` ASC");
while($menul=mysql_fetch_array($queryl)){
if (strrpos($menul['text'],'||') >= "1") {
$special = str_replace("||", "", $menul['text']);
$titlel = $menul['title'];
$idl = $menul['id'];
if(file_exists("blocks/$special.inc"))
{
LeftMenuSpecial($titlel,$special,$idl);
}
} else {

$textl = nl2br($menul['text']);
$titlel = $menul['title'];
$idl = $menul['id'];
LeftMenu($titlel,$textl,$idl);
}
}
closeLeftmenu();
}

function MenuRight() {
openRightMenu();
global $db_prefix;
$queryr = mysql_query("SELECT * FROM ". $db_prefix ."menu WHERE side='right' ORDER BY `order` ASC");
while($menur=mysql_fetch_array($queryr)){
if (strrpos($menur['text'],'||') >= "1") {
$special = str_replace("||", "", $menur['text']);
$titlep = $menur['title'];
$idr = $menur['id'];
if(file_exists("blocks/$special.inc"))
{
RightMenuSpecial($titlep,$special,$idr);
}
} else {
$trescr = nl2br($menur['text']);
$titler = $menur['title'];
$idr = $menur['id'];
RightMenu($titler,$trescr,$idr);
}
}
}
?>
