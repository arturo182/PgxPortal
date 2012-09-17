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
$site = "Ksiêga Go¶ci";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
if (!$submit) {
openSite("Ksiêga go¶ci");
MenuLeft();
if($notify != "") {
$tresc .= '
<center>
  <b>U¿ytkownik o takim nicku istnieje, je¶li ty jeste¶ '.$notify.', to zaloguj siê by dodaæ wpis do ksiêgi go¶ci pod swoim nickiem.</b>
</center>
<br>';
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."guest_book ORDER BY id DESC");
if(mysql_num_rows($query) == "0") {
$tresc .= '
<center>
  <b>Brak wpisów, Twój mo¿e byæ pierwszy!</b>
</center>
';
} else {
while($comment=mysql_fetch_array($query)){
$id = $comment['id'];
$author = $comment['author'];
$email = $comment['email'];
$date = datepl(date("d-m-Y  H:i", $comment['date']));
$text = postify($comment['text']);
$tresc .= '
<table style="border: 1px solid '.$border.';" bgcolor="'.$bgcom.'" width="390" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="left" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left: 6px;">
      ';
      if($userstatus == "Administrator") {
      $tresc .= '<a href="admin.php?mode=guestbook&action=delete&id='.$id.'#bottom">[U]</a> ';
      }
      $tresc .= "napisa³: ";
      if($email == "")
      {
      $tresc .="$email";
      }
      else
      {
      $tresc .='<a href="mailto:'.$email.'">';
      }
      $tresc .= postify($author) . '</a>
    </td>
    <td align="right" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-right: 6px;">
      napisano: '.$date.'
    </td>
  </tr>
  <tr>
    <td style="border-top: 1px solid '.$border.'; padding: 6px; text-align : justify;" colspan="2">
      ' . postify($comment[text]) . '
    </td>
  </tr>
</table>
<br><br>';
}
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$pgxuser'") or die(mysql_error());
$member = mysql_fetch_array($query);
$tresc .= '<br>
<table style="border: 1px solid '.$border.';" bgcolor="'.$bgcom.'" width="390" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td height="20" align="center" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left: 6px;">
      Dodaj wpis
    </td>
  </tr>
  <tr>
    <td align="center">
      <form method="post" action="guestbook.php">
        <table cellspacing="3">
          <tr>
            <td>
              nick:
            </td>
            <td>
              ';
              if($userstatus)
              {
              $tresc .= '<input type="hidden" name="author" value="'.$member[username].'"><input type="text" size="25" value="'.$member[username].'" disabled>
            </td>
            ';
            } else {
            $tresc .= '<input type="text" name="author" size="25">
          </td>
          ';
          }
          $tresc .= "
        </tr>
        <tr>
          <td>
            em@il:
          </td>
          <td>
            ";
            if($userstatus)
            {
            $tresc .= '<input type="hidden" name="email" value="'.$member[email].'"><input type="text" size="25" value="'.$member[email].'" disabled>';
            } else {
            $tresc .= '<input type="text" name="email" size="25">';
            }
            $tresc .= '
          </td>
        </tr>
        <tr>
          <td vailgn="top">
            tre¶æ:
          </td>
          <td>
            <textarea rows="5" cols="50" name="text"></textarea>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center">
      <input type="submit" name="submit" value="Wy¶li">
    </td>
  </tr>
</table>
</form>
';
openTable("Ksiêga go¶ci",$tresc);
MenuRight();
closeTable();
closeSite();
} else {
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$author'");
if(mysql_num_rows($query) == "1" && $pgxuser != $author) {
fastredirect("$HTTP_REFERER?notify=$author");
} else {
if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
$email = "";
}
$date = time();
if($pgxuser)
{
mysql_query("INSERT INTO ". $db_prefix ."guest_book ( `id` , `author` , `email` , `text` , `date` ) VALUES ('', '$author', '$email', '" . wordwrap($text, 50, " ", 1) . "', '$date')");
}
else
{
mysql_query("INSERT INTO ". $db_prefix ."guest_book ( `id` , `author` , `email` , `text` , `date` ) VALUES ('', '~$author', '$email', '" . wordwrap($text, 50, " ", 1) . "', '$date')");
}
fastredirect("guestbook.php");
exit;
}
}
?>
