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
require "include.php";
include "config.php";
$email = $_REQUEST['email'];
	if (isset($email)) {
	$sql="SELECT * FROM ". $db_prefix ."member WHERE email='$email'";
	$result=mysql_query($sql);
	$num_row=mysql_num_rows($result);
		if($num_row!=0) {
			$result = mysql_query("SELECT password FROM ". $db_prefix ."member WHERE email='$email'");
			$password = mysql_result($result, 0);
			$passid = randPass();
			$passid2 = encrypt($passid);
			if (!get_magic_quotes_gpc()) {
				$passid2 = addslashes($passid2);
			}
			mysql_query("UPDATE ". $db_prefix ."member SET password='$passid2' WHERE email='$email'") or die(mysql_error());
			$result = mysql_query("SELECT username FROM ". $db_prefix ."member WHERE email='$email'");
			$username = mysql_result($result, 0);
			$msg = "
			Witaj $username,
			Przysy�amy Ci ten em@il, poniewa� poprosi�es o nowe has�o na forum strony $sitename.
			Nowe has�o: $passid2
			Pozdrawiam,
			Administrator
			";
			$query = mysql_query("SELECT * FROM ". $db_prefix ."config") or die(mysql_error());
			$result = mysql_fetch_array($query);
			$aemail = $result[aemail];
			mail("$email", "Zmiana has�a", "$msg", "From: Forum <$aemail> \nReply-To: $noreply");
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo�ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>Zapomniane has�o</b>
    </td>
  </tr>
</table>
Nowe has�o zosta�o wys�ane na em@ila. Przenosz�!";
page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
redirectit("index.php");
exit;
		}
else {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo�ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
		     echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>Rejestracja</b>
    </td>
  </tr>
</table>
Podany em@il nie zosta� znaleziony w naszej bazie danych. Przenosz�!";
page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
redirectit("forgot.php");
exit;
		}
}
	      else {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo�ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
echo"
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%'>
      <b>Zapomniane has�o</b>
    </td>
  </tr>
</table>
<form method='post' action='forgot.php'>
  <table border='0' cellpadding='3' cellspacing='0' width='55%' class='header' align='center'>
    <tr>
      <td width='100%' align='center'>
        Nowe has�o
      </td>
    </tr>
  </table>
  <table border='0' cellpadding='3' cellspacing='0' width='55%' align='center'>
    <tr>
      <td width='100%' align='center'>
        Has�a u�ytkownik�w s� kodowane i dlatego, nie mo�emy Ci Twojego przypomnie�, ale mo�esz poprosic o nowe. Poprostu wpisz tutaj sw�j em@il i kliknij 'Wy�li', a wy�lemy Ci nowe has�o.
      </td>
    </tr>
    <tr>
      <td width='100%' align='center'>
        <input type='text' name='email' size='30'>
      </td>
    </tr>
    <tr>
      <td width='100%' align='center'>
        <input type='submit' name='submit' value=' Wy�li '>
      </td>
    </tr>
  </table>
</form>
";
	    }
page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
?>
