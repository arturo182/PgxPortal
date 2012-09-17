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
$site = "U¿ytkownik";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
if(!$action)
{

if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
	$query = mysql_query("SELECT * FROM ". $db_prefix ."config") or die(mysql_error());
	$result = mysql_fetch_array($query);
	$perpage = $result['maxtop'];
	if(empty($page)) {
		$page = 1;
		$start = 0;
	} else {
		$start = ($page - 1) * $perpage;
	}
	$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."member") or die(mysql_error());
	$mcount = mysql_result($query, 0);
	$multi = multipage($mcount, $perpage, $page, "member.php");
$tresc .= "
<table width='100%' colspan='0' cellspacing='0'>
  <tr>
    <td>
      <tr>
        <td background='themes/$theme/gfx/titlebg.gif' width='30%'>Nick</td>
        <td background='themes/$theme/gfx/titlebg.gif' width='30%' align='center'>Status</td>
        <td background='themes/$theme/gfx/titlebg.gif' width='25%' align='center'>Rejestracja</td>
        <td background='themes/$theme/gfx/titlebg.gif' width='15%' align='center'>Postów</td>
      </tr>
    </table>
    <table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'>
      ";
      	$ttnum = 1;
      	$query = mysql_query("SELECT * FROM ". $db_prefix ."member ORDER BY regdate LIMIT $start, $perpage") or die(mysql_error());
      	while($member = mysql_fetch_array($query)) {
      		$member[regdate] = $datetime = date("d-m-Y H:i", $member['regdate']);
      		$tresc .= "
      <tr>
        <td width='30%' background='themes/$theme/gfx/bg$ttnum.gif'><a href='member.php?action=viewpro&member=$member[uid]'>$member[username]</a></td>
        <td width='30%' background='themes/$theme/gfx/bg$ttnum.gif' align='center'>$member[status]</td>
        <td width='25%' background='themes/$theme/gfx/bg$ttnum.gif' align='center'>$member[regdate]</td>
        <td width='15%' background='themes/$theme/gfx/bg$ttnum.gif' align='center'>$member[posts]</td>
      </tr>
      ";
      		$ttnum = altcolors($ttnum);
      	}
      	$tresc .= "
    </table>
    <table width='100%' align='center'>
      <tr>
        <td align='right'>$multi</td>
      </tr>
    </table>
    ";
    MenuLeft();
    openTableMini("Lista u¿ytkowników",$tresc);
    closeTableMini();
    page_footer();
    }
if($action == "reg" && !$_POST['submit']) {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
MenuLeft();
$tresc .= "
<form method='post' action='member.php?action=reg'>
  <table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
    <tr>
      <td width='45%' height='20'>Login:</td>
      <td width='55%' height='20'><input type='text' name='username' style='width: 160px' size='20'></td>
    </tr>
    <tr>
      <td width='45%' height='10'>Has³o:</td>
      <td width='55%' height='10'><input type='password' name='password1' style='width: 160px' size='20'></td>
    </tr>
    <tr>
      <td width='45%' height='5'>Powtórz has³o:</td>
      <td width='55%' height='5'><input type='password' name='password2' style='width: 160px' size='20'></td>
    </tr>
    <tr>
      <td width='45%' height='5'>Em@il:</td>
      <td width='55%' height='5'><input type='text' name='useremail' style='width: 160px' size='20'></td>
    </tr>
    <tr>
      <td width='55%' colspan='2' align='center'><input type='submit' name='submit' value=' Wy¶li '></td>
    </tr>
  </table>
</form>
";
openTable("Rejestracja",$tresc);
MenuRight();
closeTable();
page_footer();
}
if($action == "reg" && $_POST['submit']) {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$username = $_POST['username'];
	$useremail = $_POST['useremail'];
	if (strlen($username) < 4 || strlen($username) > 15) {
$tresc .= "Login musi miec wiêcej ni¿ 4 znaki, a nie wiêcej ni¿ 15. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
exit;
}
$result = mysql_query("SELECT * FROM ". $db_prefix ."words") or die(mysql_error());
while ($myrow = mysql_fetch_array($result)) {
if (is_int(strpos($username, $myrow["word"]))) $i++;
}
if ($i>=1) {
$tresc .=  "Twój login nie moze zawieraæ s³ów, które sa objête cenzur±. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
		exit;
}
	if($password1 != $password2) {
$tresc .= "Podane has³a, nie sa jednakowe. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
		exit;
	}
	if (strlen($password1) < 5 && strlen($password2) < 5) {
$tresc .= "Has³o musi mieæ minimum 5 znaków. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
exit;
	}
	if(empty($useremail) || !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $useremail)) {
$tresc .= "Musisz podaæ prawdziwy em@il. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
		exit;
	}
	$query = mysql_query("SELECT uid FROM ". $db_prefix ."member WHERE username='$username'") or die(mysql_error());
	$member = mysql_fetch_array($query);
	if($member) {
$tresc .= "Istnieje uzytkownik o podanym loginie. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
		exit;
	}
	$query = mysql_query("SELECT email FROM ". $db_prefix ."member WHERE email='$useremail'") or die(mysql_error());
	$chkemail = mysql_fetch_array($query);
	if($chkemail) {
		$tresc .= "Podane em@il jest ju¿ zarejestrowany. Kliknij <a href='javascript: history.go(-1)'>tutaj</a> by to poprawiæ!";
MenuLeft();
openTable("Rejestracja - B³±d",$tresc);
MenuRight();
closeTable();
page_footer();
		exit;
	}
	$time = time();
	$password1 = encrypt($password1);
	mysql_query("INSERT INTO ". $db_prefix ."member VALUES ('', '$username', '$password1', 'U¿ytkownik', '$useremail', '', '', '', '', '', '$time', '0', '')") or die(mysql_error());
	$query = mysql_query("SELECT * FROM ". $db_prefix ."config") or die(mysql_error());
	$result = mysql_fetch_array($query);
	$aemail = $result[adminemail];
$header = "From: Witaj <$aemail>\nReply-To: noreply";
$subject = "Rejestracja na anszej stronie";
	$message = "Witaj $username!\n\nDziêkujemy za rejestracjê na stronie $sitename. Podajemy Ci Twój login i has³o, trzymaj je w bezpiecznym miejscu.
		Login:   $username
		Has³o:   $password2
		Has³o jest kodowane, wiêc je¶li je zapomnisz, mo¿esz u¿yæ opcji \"Zapomnia³em has³a\" na naszej stronie, by otrzymaæ nowe.
		Pozdrawiam,\nAdministrator
	";
mail($useremail, $subject, $message, $header);
	$tresc .= "Rejestracja powiod³a siê. Przenoszê!";
	redirectit("loginout.php?action=login");
MenuLeft();
openTable("Rejestracja - Sukces",$tresc);
MenuRight();
closeTable();
page_footer();
}
    if($action == "viewpro") {
    	$member = $HTTP_GET_VARS['member'];
    	$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE uid='$member'") or die(mysql_error());
    	$member = mysql_fetch_array($query);
    $email = $member['email'];
    $member[email] = nospam($email);
    	$member[regdate] = $datetime = datepl(date("d-m-Y H:i", $member['regdate']));
    if($pgxuser != "") {
    $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
    $numrows = mysql_num_rows($query);
    page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
    } else {
    page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
    }
    MenuLeft();
    if(!$email){
    $tresc .= "
    <center>
      <b>Nie ma takiego uzytkownika!</b>
    </center>
    ";
    openTableMini("Profil",$tresc);
    } else {
    $tresc .= "
    <table width='100%' cellspacing='1' cellpadding='3' border='0' align='center'>
      <tr>
        <td width='40%' align='center' background='themes/$theme/gfx/bg2.gif'><b>Avatar</b></td>
        <td width='60%' background='themes/$theme/gfx/bg2.gif'><b>Wszystko o $member[username]</b></td>
      </tr>
      <tr>
        <td height='6' valign='top' align='center'>
          ";
          if(!$member[yahoo]) {
          $tresc .= "<i>Brak avatar'u</i><br>";
          } else {
          $tresc .= "<img src='$member[yahoo]'><br>";
          }
          $tresc .= "$member[status]
        </td>
        <td rowspan='3' valign='top'>
          <table width='100%' border='0' cellspacing='1' cellpadding='3'>
            <tr>
              <td valign='middle' align='right' nowrap='nowrap'>Rejestracja:</td>
              <td width='100%'><b>$member[regdate]</b></td>
            </tr>
            <tr>
              <td valign='top' align='right' nowrap='nowrap'>Postów:</td>
              <td valign='top'><b>$member[posts]</b><br><a href='search.php?author=$member[uid]'>Znajd¼ wszystkie posty $member[username]</a></td>
            </tr>
            <tr>
              <td valign='middle' align='right' nowrap='nowrap'>Sk±d:</td>
              <td>
                ";
                if(!$member[location]) {
                $member[location] = "</b><i>Nie podano</i>";
                }
                $tresc .= "<b>$member[location]</b>
              </td>
            </tr>
            <tr>
              <td valign='middle' align='right' nowrap='nowrap'>Strona WWW:</td>
              <td>
                ";
                if(!$member[website]) {
                $member[website] = "<i>Nie podano</i>";
                } else {
                $tresc .= "<a href='$member[website]' target='_blank'> ";
                }
                $tresc .= "$member[website]</a>
              </td>
            </tr>
            <tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align='center' background='themes/$theme/gfx/bg2.gif'>
            <b>Kontakt z $member[username]</b>
          </td>
        </tr>
        <tr>
          <td valign='top'>
            <table width='100%' border='0' cellspacing='1' cellpadding='3'>
              <tr>
                <td valign='middle' align='right' nowrap='nowrap'>
                  Adres email:
                </td>
                <td valign='middle' width='100%'>
                  <b><a href='mailto:$member[email]'>$member[email]</a></b>
                </td>
              </tr>
              <tr>
                <td valign='middle' nowrap='nowrap' align='right'>
                  Numer GG:
                </td>
                <td valign='middle'>
                  ";
                  if(!$member[aim]) {
                  $member[aim] = "<i>Nie podano</i>";
                  } else {
                  $tresc .= "<img src='http://www.gadu-gadu.pl/users/status.asp?id=$user[aim]&styl=1'> ";
                  }
                  $tresc .= "$member[aim]
                </td>
              </tr>
              <tr>
                <td valign='middle' nowrap='nowrap' align='right'>
                  Tlen.pl:
                </td>
                <td>
                  ";
                  if(!$member[msn]) {
                  $member[msn] = "<i>Nie podano</i>";
                  } else {
                  $tresc .= "<img src='http://status.tlen.pl/?u=$member[msn]&t=1'>";
                  }
                  $tresc .= " $member[msn]
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      ";
      openTableMini("Profil - $member[username]",$tresc);
      }
      closeTableMini();
      page_footer();
      }
      if($action == "editpro" && !$_POST['submit']) {
      if($pgxuser != "") {
      $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
      $numrows = mysql_num_rows($query);
      page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
      } else {
      page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
      }
      MenuLeft();
      	if(empty($pgxuser) || empty($pgxpass)) {
      $tresc .= "Proszê siê <a href='loginout.php?action=login'>zalogowaæ</a> lub <a href='member.php?action=reg'>zarejestrowaæ</a> by mieæ tutaj dostêp.";
      openTable("Edycja Profilu",$tresc);
      MenuRight();
      closeTable();
      page_footer();
      		exit;
      	}
      	$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$pgxuser'") or die(mysql_error());
      	$member = mysql_fetch_array($query);
      $tresc .= "
      <form method='post' name='myForm' action='member.php?action=editpro'>
        <Center>
          <table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'>
            <tr>
              <td width='40%'>Zmieñ has³o:</td>
              <td width='60%'><input type='password' name='newpassword' size='30' style='width: 200px'></td>
            </tr>
            <tr>
              <td width='40%'>Powtórz nowe has³o:</td>
              <td width='60%'>
                <input type='password' name='newpassword2' size='30' style='width: 200px'>
              </td>
            </tr>
          </table>
          <table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'>
            <tr>
              <td width='40%'>Em@il:</td>
              <td width='60%'><input type='text' name='newemail' size='30' style='width: 200px' value='$member[email]'></td>
            </tr>
            <tr>
              <td width='40%'>WWW:</td>
              <td width='60%'><input type='text' name='newwebsite' size='30' style='width: 200px' value='$member[website]'></td>
            </tr>
            <tr>
              <td width='40%'>Gadu-Gadu:</td>
              <td width='60%'><input type='text' name='newaim' size='30' style='width: 200px' value='$member[aim]'></td>
            </tr>
            <tr>
              <td width='40%'>Tlen:</td>
              <td width='60%'><input type='text' name='newmsn' size='30' style='width: 200px' value='$member[msn]'></td>
            </tr>
            <tr>
              <td width='40%'>Sk±d:</td>
              <td width='60%'><input type='text' name='newlocation' size='30' style='width: 200px' value='$member[location]'></td>
            </tr>
          </table>
          <table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'>
            <tr>
              <td width='100%' colspan='2'>Podpis/Sygnatura</td>
            </tr>
            <tr>
              <td width='100%' colspan='2'><textarea cols='68' rows='5' name='newsig'>$member[sig]</textarea></td>
            </tr>
            <tr>
              <td width='50%'>Avatar</td>
              <td width='50%'>Obecny</td>
            </tr>
            <tr>
              <td width='50%' valign='top'>
                <input type='text' name='newyahoo' size='30' style='width: 200px' value='$member[yahoo]'>
              </td>
              <td width='50%'>
                ";
                if($member[yahoo] != "") {
                $tresc .=  "<img src='$member[yahoo]'>";
                } else {
                $tresc .= "--brak--";
                }
                $tresc .= "
              </td>
            </tr>
          </tr>
          <tr>
            <td width='100%' align='center' colspan='2'>
              <input type='submit' class='b' name='submit' value=' Zapisz '>
            </td>
          </tr>
        </table>
      </center>
    </form>
    ";
    openTable("Edycja Profilu",$tresc);
    MenuRight();
    closeTable();
    page_footer();
    }
    if($action == "editpro" && $_POST['submit']) {
    if($pgxuser != "") {
    $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
    $numrows = mysql_num_rows($query);
    page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
    } else {
    page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
    }
    	$newemail = $_POST['newemail'];
    	$newwebsite = $_POST['newwebsite'];
    	$newaim = $_POST['newaim'];
    	$newmsn = $_POST['newmsn'];
    $newyahoo = $_POST['newyahoo'];
    	$newlocation = $_POST['newlocation'];
    	$newsig = $_POST['newsig'];
    	if($_POST['newpassword'] && $_POST['newpassword'] != $_POST['newpassword2']) {
    		$tresc .= "Podane has³a nie s± poprawne. Przenoszê!";
    MenuLeft();
    openTable("Edycja profilu - B³±d",$tresc);
    MenuRight();
    closeTable();
    page_footer();
    		redirectit("member.php?action=editpro");
    		exit;
    	}
    	
    	if(trim($newyahoo) != "")
    	{
    	if(@fopen($newyahoo, "r"))
    	 {
    	  list($width, $height) = getimagesize("$newyahoo");

    	   if($width > $avatar_width OR $height > $avatar_height)
            {
             $tresc .= "Awatar jest za du¿y!<br><br>Max wysoko¶æ <b>$avatar_height</b><br>Max szeroko¶æ <b>$avatar_width</b><br><br><a href='javascript: history.go(-1)'>Wróæ</a>";
             MenuLeft();
             openTable("Edycja profilu - B³±d",$tresc);
             MenuRight();
             closeTable();
             page_footer();
    	     exit;
    	    }
    	}
    	else
    	{
         $tresc .= "B³êdny adres awatara";

             MenuLeft();
             openTable("Edycja profilu - B³±d",$tresc);
             MenuRight();
             closeTable();
             page_footer();
    	     exit;
    	}
    	}
    	$newyahoo == "";
    	
    	if($_POST['newpassword']) {
    	$newpassword = encrypt($_POST['newpassword']);
    	mysql_query("UPDATE ". $db_prefix ."member SET password='$newpassword' WHERE username='$pgxuser'") or die(mysql_error());
    	MenuLeft();
    openTable("Rejestracja - B³±d","Has³o zmieniono. Przenoszê!");
    MenuRight();
    closeTable();
    page_footer();
    	redirectit("loginout.php?action=login");
    	} else {
    	mysql_query("UPDATE ". $db_prefix ."member SET email='$newemail', website='$newwebsite', aim='$newaim', msn='$newmsn', location='$newlocation', sig='$newsig', yahoo='$newyahoo' WHERE username='$pgxuser'") or die(mysql_error());
    MenuLeft();
    openTable("Edycja profilu","Profil uaktualniono. Przenoszê!");
    MenuRight();
    closeTable();
    page_footer();
    	fastredirect("member.php?action=editpro");
    }
    }
?>
