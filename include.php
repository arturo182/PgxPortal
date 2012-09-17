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
if(filesize("config.php") <= "150")
{
header("Location: install.php");
exit;
}

include "config.php";

if($_COOKIE['pgxstats'] != "1")
{
$query = mysql_query("SELECT * FROM ". $db_prefix ."stats") or die(mysql_error());
while($stats = mysql_fetch_array($query)){
$counter = $stats['counter'] + 1;
$msie = $stats['msie'];
$opera = $stats['opera'];
$mozilla = $stats['mozilla'];
$other = $stats['other'];
$win98 = $stats['win98'];
$winxp = $stats['winxp'];
$linux = $stats['linux'];
$osther = $stats['osther'];
if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) {
$msie = $stats['msie'] + 1;
} elseif(strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) {
$opera = $stats['opera'] + 1;
} elseif(strpos($_SERVER["HTTP_USER_AGENT"], "Mozilla") !== false) {
$mozilla = $stats['mozilla'] + 1;
} else {
$other = $stats['other'] + 1;
}
if (strpos($_SERVER["HTTP_USER_AGENT"], "98") !== false) {
$win98 = $stats['win98'] + 1;
} elseif(strpos($_SERVER["HTTP_USER_AGENT"], "NT") !== false) {
$winxp = $stats['winxp'] + 1;
} elseif(strpos($_SERVER["HTTP_USER_AGENT"], "linux") !== false) {
$linux = $stats['linux'] + 1;
} else {
$osther = $stats['osther'] + 1;
}
mysql_query("DELETE FROM ". $db_prefix ."stats");
mysql_query("INSERT INTO ". $db_prefix ."stats ( `counter` , `msie` , `opera` , `mozilla` , `other`, `win98`, `winxp`, `linux`, `osther`) VALUES ('$counter', '$msie', '$opera', '$mozilla', '$other', '$win98', '$winxp', '$linux', '$osther');");
}
}

if(!$_COOKIE['pgxstats'])
{
setcookie("pgxstats","1",time()+3600);
}

if(getenv(HTTP_CLIENT_IP)) {
	$aipi = getenv(HTTP_CLIENT_IP);
} else {
	$aipi = getenv(REMOTE_ADDR);
}
$ipq = mysql_query("SELECT * FROM ". $db_prefix ."bans WHERE IP='$aipi'");
if(mysql_num_rows($ipq) > 0) {
die("Sorry, ale Twoje IP zosta³o zabanowane przez admina strony.");
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."config");
$config=mysql_fetch_array($query);
$adminpass = $config['adminpass'];
$owner = $config['owner'];
$sitename = $config['sitename'];
$theme = $config['theme'];

$avatar_width = $config['avatar_width'];
$avatar_height = $config['avatar_height'];

$guests_download_files = $config['guests_download_files'];
$allow_guests_stats = $config['stats'];
$allow_guests_comments = $config['comments'];
$allow_guests_pool = $config['pool'];

$adminemail = $config['adminemail'];
$siteadress = $config['siteadress'];

if(!$_COOKIE['pgxtheme'])
{
$theme = $config['theme'];
}
else
{
$theme = $_COOKIE['pgxtheme'];
}

$nlimit = $config['nlimit'];

require "functions.php";
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$pgxuser'") or die(mysql_error());
$member = mysql_fetch_array($query);

if($member == "") {
	$pgxuser = "";
	$pgxpass = "";
	$userstatus = "";
}
if($member[password] != $pgxpass) {
	$pgxuser = "";
	$pgxpass = "";
	$userstatus = "";
}
if($pgxuser != "" && $pgxpass != "")
{
$userstatus = $member['status'];
}

$pgxuser = $member['username'];
require "themes/$theme/forum.php";
if(getenv(HTTP_CLIENT_IP)) {
	$thisip = getenv(HTTP_CLIENT_IP);
} else {
	$thisip = getenv(REMOTE_ADDR);
}
$time = time();
$newtime = $time - 300;
mysql_query("DELETE FROM ". $db_prefix ."online WHERE ip='$thisip' OR time<'$newtime'");
if($pgxuser == "")
{
mysql_query("INSERT INTO ". $db_prefix ."online VALUES('$thisip', '$time', 'guest', '$site')") or die(mysql_error());
}
else
{
mysql_query("INSERT INTO ". $db_prefix ."online VALUES('$thisip', '$time', '$pgxuser', '$site')") or die(mysql_error());
}

$memcount           = mysql_num_rows(mysql_query("SELECT * FROM ". $db_prefix ."member"));
$postcount          = mysql_num_rows(mysql_query("SELECT * FROM ". $db_prefix ."post"));
$topic_count        = mysql_num_rows(mysql_query("SELECT * FROM ". $db_prefix ."topic"));
$onlinecount        = mysql_num_rows(mysql_query("SELECT * FROM ". $db_prefix ."online"));

$fjump = "<option value='main'>Forum Main</option>
<option value=''>--------------------</option>";
$query = mysql_query("SELECT * FROM ". $db_prefix ."forum ORDER BY `dorder` ASC");
while($forum = mysql_fetch_array($query)) {
	$fjump .= "<option value='$forum[fid]'>$forum[name]</option>\n";
}
if($pgxuser != "" && $pgxpass != "") {
	$themsg[0] = 'Witaj <b>'.$pgxuser.'</b> (<a href="loginout.php?action=logout">Wyloguj</a>)';
	$themsg[1] = '<a href="forum.php">Forum</a> - <a href="member.php">U¿ytkownicy</a> - <a href="member.php?action=editpro">Profil</a>';
} else {
	$themsg[0] = 'Witaj <b>Go¶æ</b> (<a href="loginout.php?action=login">Zaloguj</a>)';
	$themsg[1] = '<a href="forum.php">Forum</a> - <a href="member.php">U¿ytkownicy</a> - <a href="member.php?action=reg">Rejestracja</a>';
}
if($userstatus == "Administrator") {
	$themsg[1] .= ' - <a href="admin.php?action=settings">Administracja</a>';
}
function get_microtime() {
	$mtime=explode(' ',microtime());
	return $mtime[1]+$mtime[0];
}
function postify($message) {
global $db_prefix;
$message = str_replace("<", "&lt;", $message);
	$message = str_replace(">", "&gt;", $message);
	$message = str_replace("[hr]", '<hr>', $message);
$message = preg_replace("#www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[a-z0-9\-\.,\?!%\*_\#:;~\\&$@\/=\+]*)?)#i", "<a href=\"http://www.\\1.\\2\\3\" target=\"_blank\">www.\\1.\\2\\3\\4</a>", $message);
$message = preg_replace("#([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)#i", "<a href=\"mailto:\\1@\\2\">\\1@\\2</a>", $message);
$CodeLayout = '
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr>
    <td>
      <b>Kod:</b>
    </td>
  </tr>
  <tr>
    <td class="code">
      $1
    </td>
  </tr>
</table>
';
$message = preg_replace("/\[code\](.+?)\[\/code\]/is","$CodeLayout", $message);
	$db_smiley = $GLOBALS['db_smiley'];
	$db_words = $GLOBALS['db_words'];
	$query = mysql_query("SELECT * FROM ". $db_prefix ."smiley") or die(mysql_error());
	while($smiley = mysql_fetch_array($query)) {
		$message = str_replace("$smiley[code]", "<img src='image/smiles/$smiley[url]' align='middle'>", $message);
	}
$message = nl2br($message);
$message = preg_replace("(\[b\](.+?)\[\/b])is",'<b>$1</b>',$message);
$message = preg_replace("(\[i\](.+?)\[\/i\])is",'<i>$1</i>',$message);
$message = preg_replace("(\[u\](.+?)\[\/u\])is",'<u>$1</u>',$message);
$message = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<font color=\"$1\">$2</font>",$message);
$message = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","
<span style=\"font-size: $1px\">
  $2
</span>
",$message);
$message = preg_replace("(\[glo=(.+?)\](.+?)\[\/glo\])is","
<span style=\"filter: glow(color=$1); height:10\">
  $2
</span>
",$message);
$QuoteLayout = '
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr>
    <td>
      <b>Cytat:</b>
    </td>
  </tr>
  <tr>
    <td class="quote">
      $1
    </td>
  </tr>
</table>
';
$QuoteLayout2 = '
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr>
    <td>
      <b>$1 napisa³(a):</b>
    </td>
  </tr>
  <tr>
    <td class="quote">
      $2
    </td>
  </tr>
</table>
';
$message = preg_replace("/\[quote\=(.+?)\](.+?)\[\/quote\]/is","$QuoteLayout2", $message);
$message = preg_replace("/\[quote\](.+?)\[\/quote\]/is","$QuoteLayout", $message);
$message = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1">', $message);
$message = preg_replace("/\[url\](.+?)\[\/url\]/", '<a href="$1">$1</a>', $message);
$message = preg_replace("/\[url\=(.+?)\](.+?)\[\/url\]/", '<a href="$1">$2</a>', $message);
$message = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1">', $message);
	$wordcount = 0;
	$query = mysql_query("SELECT word, replacement FROM ". $db_prefix ."words") or die(mysql_error());
	while($result = mysql_fetch_array($query)) {
		$message = eregi_replace($result["word"], $result["replacement"], $message);
		$wordcount++;
	}
	return $message;
}
function altcolors($ttnumorig) {
	if($ttnumorig == 1) {
		$ttnum = 2;
	} elseif($ttnumorig == 2) {
		$ttnum = 1;
	}
	return $ttnum;
}
function encrypt($string) {
$crypted = crypt(md5($string), md5($string));
return $crypted;
}
function randPass() {
$salt = "abchefghjkmnpqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
while ($i <= 7) {
$num = rand() % 33;
$tmp = substr($salt, $num, 1);
$pass = $pass . $tmp;
$i++;
}
return $pass;
}
function nospam($email) {
$email = str_replace('@','(ma³pa)',$email);
return $email;
}
function multipage($count, $perpage, $page, $pageurl) {
global $theme;
	if($count > $perpage) {
		$pagenum = $count / $perpage;
		$pagenum = ceil($pagenum);
		if($page == $pagenum) {
			$to = $pagenum;
		} elseif($page == $pagenum - 1) {
			$to = $page + 1;
		} elseif($page == $pagenum - 2) {
			$to = $page + 2;
		} else {
			$to = $page + 3;
		}
		if($page < 4) {
			$from = 1;
		} else {
			$from = $page - 3;
		}
		$multicode = 'Strony: <a href="$pageurl&page=1"><img border="0" src="themes/'.$theme.'/gfx/lt.gif" alt="Wstecz" align="absmiddle" width="3" height="5"></a>';
		for($i = $from; $i <= $to; $i++) {
			if($i == $page) {
				$multicode .= "&nbsp;<b>[$i]</b>&nbsp;";
			} else {
				$multicode .= '&nbsp;<a href="'.$pageurl.'&page='.$i.'">'.$i.'</a>&nbsp;';
			}
		}
		$multicode .= '<a href="'.$pageurl.'&page='.$pagenum.'"><img border="0" src="themes/'.$theme.'/gfx/rt.gif" alt="Dalej" align="absmiddle" width="3" height="5"></a>';
	}
	if($multicode == "") {
		$multicode = "";
	}
	return $multicode;
}
function datepl($m) {
$mi = explode("-", $m);
if ($mi[1] == 01) {$m = $mi[0] . " sty " . $mi[2];}
if ($mi[1] == 02) {$m = $mi[0] . " lut " . $mi[2];}
if ($mi[1] == 03) {$m = $mi[0] . " mar " . $mi[2];}
if ($mi[1] == 04) {$m = $mi[0] . " kwi " . $mi[2];}
if ($mi[1] == 05) {$m = $mi[0] . " maj " . $mi[2];}
if ($mi[1] == 06) {$m = $mi[0] . " cze " . $mi[2];}
if ($mi[1] == 07) {$m = $mi[0] . " lip " . $mi[2];}
if ($mi[1] == 08) {$m = $mi[0] . " sie " . $mi[2];}
if ($mi[1] == 09) {$m = $mi[0] . " wrz " . $mi[2];}
if ($mi[1] == 10) {$m = $mi[0] . " pa¼ " . $mi[2];}
if ($mi[1] == 11) {$m = $mi[0] . " lis " . $mi[2];}
if ($mi[1] == 12) {$m = $mi[0] . " gru " . $mi[2];}
return $m ;
}

function checkuserpermsv($userstatus, $perms) {
	$perms = explode("_", $perms);

	if($perms[0] == 2 && $userstatus != "Moderator" && $userstatus != "Administrator") {
		$access = 0;
	} elseif($perms[0] == 3 && $userstatus != "Administrator") {
		$access = 0;
	} else {
		$access = 1;
	}

	return $access;
}

?>
