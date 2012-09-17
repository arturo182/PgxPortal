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
$site = "Prywatne Wiadomo¶ci";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
if(empty($pgxuser) || empty($pgxpass)) {
$tresc .= "Musisz byæ zalogowany, by mieæ tutaj dostêp. <a href='loginout.php?action=login'>Zaloguj siê</a> lub <a href='member.php?action=reg'>Zarejestruj</a>.";
MenuLeft();
openTable("Prywatne wiadomo¶ci",$tresc);
MenuRight();
closeTable();
page_footer();
	exit;
}
if(!$action) {
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
$tresc .= "<br>
<center>
  <a href='privmsg.php?action=send'><b>Napisz now± prywatn± wiadomo¶æ</b></A>
</center>
<bR><bR>";
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
if(empty($numrows)) {
$tresc .= "
<center>
  Nie masz ¿adnych prywatnych wiadomo¶ci.<br><br>
</center>
";
} else {
while($privmsg = mysql_fetch_array($query)) {
		$sent = $datetime = date("d-m-Y H:i", $privmsg['time']);
		$message = postify($privmsg['message']);
$tresc .= "
<table border='0' cellpadding='4' cellspacing='1' width='100%'>
  <tr>
    <td colspan='3' align='right' background='themes/$theme/gfx/bg2.gif'>
      &nbsp;
    </td>
  </tr>
  <tr>
    <td background='themes/$theme/gfx/bg2.gif'>
      Od:
    </td>
    <td background='themes/$theme/gfx/bg1.gif' width='100%' colspan='2'>
      <a href='member.php?action=viewpro&member=$privmsg[sender]'>$privmsg[sender]</A>
    </td>
  </tr>
  <tr>
    <tr>
      <td background='themes/$theme/gfx/bg2.gif'>
        Wys³any:
      </td>
      <td background='themes/$theme/gfx/bg1.gif' width='60%' colspan='2'>
        $sent
      </td>
    </tr>
    <tr>
      <td background='themes/$theme/gfx/bg2.gif'>
        Temat:
      </td>
      <td background='themes/$theme/gfx/bg1.gif' width='60%' colspan='2'>
        $privmsg[topic]
      </td>
    </tr>
    <tr>
      <td background='themes/$theme/gfx/bg1.gif' valign='top' colspan='3'>
        $message
      </td>
    </tr>
    <tr>
      <td colspan='3' align='right' background='themes/$theme/gfx/bg2.gif'>
        <a href='privmsg.php?action=delete&remove=$privmsg[id]'>Skasuj wiadomo¶æ</a> | <a href='privmsg.php?action=return&reply=$privmsg[id]'>Odpowiedz</a>
      </td>
    </tr>
  </table>
  <br>";
  }
  }
  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  }
  if($action == "delete") {
  if($pgxuser != "") {
  $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
  $numrows = mysql_num_rows($query);
  page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
  } else {
  page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
  }
  mysql_query("DELETE FROM privmsg WHERE id='$remove' and receiver='$pgxuser'");
  $tresc .= "Wiadomo¶æ skasowana. Przenoszê!";
  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  redirectit("privmsg.php");
  }
  if($action == "return" && $_POST['submit']) {
  if($pgxuser != "") {
  $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
  $numrows = mysql_num_rows($query);
  page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
  } else {
  page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
  }
  	  if(!$_POST['receiver'] || !$_POST['reply_message']) {
  	  $tresc .= "Nie wype³ni³e¶ wszystkich pól. <a href='javascript: history.go(-1)'>Wróæ</a> i popraw to!";
  	  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  	  page_footer();
  	  exit;
  	  }
  	  $time = time();
  	  $query = mysql_query("INSERT INTO ". $db_prefix ."privmsg (id, sender, message, time, receiver, topic) VALUES ('', '$sender', '$reply_message', '$time', '$receiver', '$topic')") or die(mysql_error());
  	  $tresc .= "Odpowied¼ wys³ana. Przenoszê!";
  	  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  	  redirectit("privmsg.php");
  }
  if($action == "return" && !$_POST['submit']) {
  if($pgxuser != "") {
  $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
  $numrows = mysql_num_rows($query);
  page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
  } else {
  page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
  }
  		$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' and id='$reply'") or die(mysql_error());
  		$result = mysql_fetch_array($query);
  		$tresc .= "<br>
  <table border='0' cellpadding='4' cellspacing='0' width='65%' align='center'>
    <form action='privmsg.php?action=return' method='post'>
      <input type='hidden' name='receiver' value='$result[sender]'>
      <tr>
        <input type='hidden' name='sender' value='$pgxuser'><br>
        <td width='20%'>
          Temat:
        </td>
        <td width='80%'>
          <input type='text' name='topic' value='Odp: $result[topic]' size='55'>
        </td>
      </tr>
      <tr>
        <td width='20%' valign='top'>
          Wiadomo¶æ:
        </td>
        <td width='80%'>
          <textarea rows='10' cols='54' name='reply_message'>[quote]$result[message][/quote]
          </textarea>
        </td>
      </tr>
      <tr>
        <td width='100%' align='center' colspan='2'>
          <input type='submit' name='submit' value=' Wy¶li '>
        </td>
      </tr>
    </form>
  </table>
  ";
  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  }
  if($action == "send" && $_POST['submit']) {
  if($pgxuser != "") {
  $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
  $numrows = mysql_num_rows($query);
  page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
  } else {
  page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
  }
  	  if(!$_POST['receiver'] || !$_POST['send_message']) {
  	  $tresc .= "Nie wype³ni³e¶ wszystkich pól. <a href='javascript: history.go(-1)'>Wróæ</a> i popraw to!";
  	  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  	  page_footer();
  	  exit;
  	  }
  	  $time = time();
  	  $query = mysql_query("INSERT INTO privmsg (id, sender, message, time, receiver, topic) VALUES ('', '$sender', '$send_message', '$time', '$receiver', '$topic')") or die(mysql_error());
  	  $tresc .="Wiadomosæ wys³ano. Przenoszê!";
  	  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  	  redirectit("privmsg.php");
  }
  if($action == "send" && !$_POST['submit']) {
  if($pgxuser != "") {
  $query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
  $numrows = mysql_num_rows($query);
  page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
  } else {
  page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
  }
  
   $queryX = mysql_query("SELECT * FROM ". $db_prefix ."member ORDER BY username") or die(mysql_error());
   $count = mysql_num_rows($queryX);
  		$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' and id='$reply'") or die(mysql_error());
  		$result = mysql_fetch_array($query);
  		$tresc .= "
  <table border='0' cellpadding='4' cellspacing='0' width='65%' align='center'>";
  if($count != "1")
  {
  $tresc .= "<form action='privmsg.php?action=send' method='post'>";
  }
  
     $tresc .= "<tr>
        <td width='20%'>Odbiorca:</td>
        <td width='80%'>";
        
          if($count == "1")
          {
          $tresc .= "Jest tylko jeden zarejestrowany u¿ytkownik";
          }
          else
          {
          $tresc .= "<select name='receiver'>";
          while($result = mysql_fetch_array($queryX))
          {
           if($result[username] != $pgxuser)
           {
            $tresc .= "<option value='$result[username]'>$result[username]</option>";
           }
          }
        	$tresc .= "</select>";
          }
       $tresc .= "</td>
      </tr>
      <tr>
        <input type='hidden' name='sender' value='$pgxuser'><br>
        <td width='20%'>Temat:</td>
        <td width='80%'><input type='text' name='topic' value='' size='55'></td>
      </tr>
      <tr>
        <td width='20%' valign='top'>Wiadomo¶æ:</td>
        <td width='80%'><textarea rows='10' cols='54' name='send_message'></textarea></td>
      </tr>
      <tr>
        <td width='100%' align='center' colspan='2'>";
          if($count == "1")
          {
          $tresc .= "<input type='submit' name='submit' value=' Wy¶li ' disabled></td>";
          }
          else
          {
          $tresc .= "<input type='submit' name='submit' value=' Wy¶li '></td>";
          }
$tresc .= "      </tr>";

          if($count != "1")
          {
  $tresc .= "</form>";
           }
  $tresc .= "</table>";
  MenuLeft();
  openTableMini("Prywatne wiadomo¶ci",$tresc);
  closeTableMini();
  }
  page_footer();
?>
