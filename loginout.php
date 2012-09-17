<?php
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
$site = "Logowanie";
include "include.php";
include "config.php";
if($action == "login" && !$_POST['submit']) {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
	echo "
<form method='post' action='loginout.php?action=login'>
  <table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
    <tr>
      <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
        <b>Logowanie</b>
      </td>
    </tr>
  </table>
  <table border='0' cellpadding='3' cellspacing='0' width='55%' align='center'>
    <tr>
      <td width='45%' height='20'>Login:</td>
      <td width='55%' height='20'><input type='text' name='username' style='width: 160px' size='20'></td>
    </tr>
    <tr>
      <td width='45%' height='20'>Has³o:</td>
      <td width='55%' height='20'><input type='password' name='password' style='width: 160px' size='20'>
      </td>
    </tr>
    <tr>
      <td width='55%' colspan='2' align='center'><input type='submit' name='submit' value=' Wy¶lij '></td>
    </tr>
  </table>
  <table border='0' cellpadding='3' cellspacing='0' width='55%' align='center'>
    <tr>
      <td width='100%' class='sign' align='center'>Zapomnia³e¶ has³a? Kliknij <a href='forgot.php'>tutaj</a></td>
    </tr>
  </table>
</form>
";
page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
}
if($action == "login" && $_POST['submit']) {
	if(!$_POST['username'] || !$_POST['password']) {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
		echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>B³±d logowania</b>
    </td>
  </tr>
</table>
Nie wype³ni³e¶ wszytskich pól, spróbuj <a href=\"javascript: history.go(-1)\">ponownie</a>!";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	if (!get_magic_quotes_gpc()) {
		$password = addslashes($_POST['password']);
	}
	$password = $_POST['password'];
	$password = encrypt($password);
	$username = $_POST['username'];
	$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$username'") or die(mysql_error());
	$member = mysql_fetch_array($query);
	if(empty($member)) {
			if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
		echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>B³±d logowania</b>
    </td>
  </tr>
</table>
Nie ma takiego u¿ytkownika, spróbuj <a href=\"javascript: history.go(-1)\">ponownie</a>!";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	if($member['password'] != $password) {
			if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
		echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>B³±d logowania</b>
    </td>
  </tr>
</table>
Z³e has³o, spróbuj <a href=\"javascript: history.go(-1)\">ponownie</a>!<br>";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	$time = time() + (86400*365);
	setcookie("pgxuser", $username, $time);
	setcookie("pgxpass", $password, $time);
	if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
	echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>Zalogowany pomy¶lnie</b>
    </td>
  </tr>
</table>
Witaj <b>$username</b>! Teraz jestes zalogowany. Przenoszê!<br><br>";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
redirectit("index.php");
}
if($action == "logout") {
	$time = time() - (86400*365);
	setcookie("pgxuser", $username, $time);
	setcookie("pgxpass", $password, $time);
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
	echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>Wylogowany pomy¶lnie</b>
    </td>
  </tr>
</table>
Do zobaczenia $nbuser! Jeste¶ teraz wylogowany. Przenoszê!<br><br>";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
redirectit("index.php");
}
?>
