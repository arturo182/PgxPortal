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
$site = "Newsy";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
$guests = $allow_guests_comments;

openSite("Komentowanie newsów");
MenuLeft();

if(!$submit) {
if($notify != "") {
$tresc .= "
<center>
  <b>U¿ytkownik o takim nicku istenieje, je¶li ty jeste¶ $notify, to zaloguj siê by dodaæ komentarz pod swoim nickiem.</b>
</center>
<br>";
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."news where id='$id'");
if (mysql_num_rows($query) == "0") {
$title = "B³±d";
$tresc .= "Nie istnieje news o podanym ID!";
} else {
while($article=mysql_fetch_array($query)){
$id = $article['id'];
$title = $article['title'];
$date = $article['date'];
$tresc .= postify($article['text'])."<hr>";
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."news_comments where newsid='$id' ORDER BY id DESC");
if(mysql_num_rows($query) == "0") {
$tresc .= "
<center>
  <b>Nie ma jeszcze ¿adnych komenatarzy do tego newsa, Twój mo¿e byæ pierwszy!</b>
</center>
";
} else {
while($comment=mysql_fetch_array($query)){
$author = $comment['author'];
$query2 = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$author'");
$date = datepl(date("d-m-Y  H:i", $comment['date']));
$text = $comment['text'];
$tresc .= '<br><br>
<table style="border: 1px solid #1c1c1c;" bgcolor="'.$border.'" width="390" border="0" cellspacing="0" cellpadding="0" bgcolor="$bgcom">
  <tr>
    <td height="20" align="left" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left: 6px;">
      ';
      if($userstatus == "Administrator") {
      $tresc .= '<a href="admin.php?mode=news&action=deletec&id=' . $comment[id] . '#bottom">[U]</a> ';
      }
      $tresc .= "napisa³: ";
      if(mysql_num_rows($query2) == "0") {
      $tresc .= "~" . postify($author) . "";
      } else {
      
      $who_write = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username = '$author'"));
      
      $tresc .= '<a href="member.php?action=viewpro&member='.$who_write[uid].'">'.$author.'</a>';
      }
      $tresc .= '
    </td>
    <td align="right" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-right: 6px;">napisano: '.$date.'</td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; padding: 6px; text-align : justify;" colspan="2" bgcolor="'.$bgcom.'">' . postify($comment[text]) . '</td>
  </tr>
</table>
';
}
}
if (!$pgxuser && $guests == "0") {
$tresc .= '<br>
<center>
  <b>Tylko <a href="member.php?action=reg">zarejestrowani</a> i <a href="loginout.php?action=login">zalogowani</a> u¿ytkownicy mog± dodawaæ komentarze.</b>
</center>
';
} else {
$tresc .= '<br><br>
<table style="border: 1px solid '.$border.';" bgcolor="'.$bgcom.'" width="390" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td height="20" align="center" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left: 6px;">
      Dodaj komentarz
    </td>
  </tr>
  ';
  if($guests == "1" && !$pgxuser) {
  $tresc .= "
  <tr>
    <td align='center'>
      <form method='post' action='news.php'>
        Autor: <input type='text' name='author' >
      </td>
    </tr>
    ";
    }
    elseif($pgxuser)
    {
    $tresc .= '
    <tr>
      <td align="center">
        <form method="post" action="news.php">
          Autor: <input type="text" value="' . $pgxuser . '" disabled><input type="hidden" name="author" value="' . $pgxuser . '">
        </td>
      </tr>
      ';
      }
      $tresc .= '
      <tr>
        <td align="center">
          <textarea rows="5" cols="70" name="text"></textarea>
        </td>
      </tr>
      <tr>
        <td align="center">
          <input type="hidden" name="id" value="' .$id . '"><input type="submit" name="submit" value="Wy¶li">
        </form>
      </td>
    </tr>
  </table>
  ';
  }
  }

  }
  else
  {
  $query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$author'");
  if(mysql_num_rows($query) == "1" && $pgxuser != $author)
  {
  echo '<script language="javascript">window.location="'. $HTTP_REFERER .'&notify='. $author .'"</script>';
  }
  else
  {
  if(trim($author) == "")
  {
  $title .= "Komentarz";
  $tresc .= "Wpisz nick";
  }
  elseif(trim($text) == "")
  {
  $title .= "Komentarz";
  $tresc .= "Wpisz tre¶æ komentarza";
  }
  else
  {
  $date = time();
  mysql_query("INSERT INTO ". $db_prefix ."news_comments ( `newsid` , `author` , `text` , `date` ) VALUES ('$id', '$author', '$text', '$date')");
  echo '<script language="javascript">window.location="'. $HTTP_REFERER .'"</script>';
  }
  }
  }
  openTable($title,$tresc);
  MenuRight();
  closeTable();
  closeSite();
?>
