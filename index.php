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
$site = "Strona G³ówna";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";

openSite("Strona g³ówna");
MenuLeft();
$title = "Newsy";
$query = mysql_query("SELECT * FROM ". $db_prefix ."news ORDER BY id DESC limit $nlimit");
while($article=mysql_fetch_array($query)){
$id = $article['id'];
$title2 = $article['title'];
$date = datepl(date("d-m-Y  H:i", $article['date']));
$author_id = $article['author'];
$query2 = mysql_query("SELECT * FROM ". $db_prefix ."news_comments where newsid='$id'");
$comments = mysql_num_rows($query2);

$who_write = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE uid = '$author_id'"));
$tresc .= '
<table style="border: 1px solid '.$border.';" bgcolor="'.$bgcom.'" width="390" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left: 6px;">
      ';
      if($userstatus == "Administrator") {
      $tresc .= '<a href="admin.php?mode=news&action=delete&id='.$id.'#bottom">[U]</a> <a href="admin.php?mode=news&action=edit&id='.$id.'#bottom">[E]</a>';
      }
      $tresc .= '<strong>'.$title2.'</strong>
    </td>
    <td background="themes/'.$theme.'/gfx/titlebg2.gif" align="right">'.$date.'&nbsp;</td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; padding: 6px; text-align : justify;" colspan="2">'.  postify($article[text]) . '</td>
  </tr>
  <tr>
    <td background="themes/'.$theme.'/gfx/titlebg2.gif" style="border-top: 1px solid #000000;padding-top: 3px;padding-bottom: 3px;padding-right: 3px;">
      &nbsp;Napisa³: <a href="member.php?action=viewpro&member='. $author_id .'">'. $who_write[username] .'</a>
    </td>
    <td align="right" background="themes/'.$theme.'/gfx/titlebg2.gif" style="border-top: 1px solid #000000;padding-top: 3px;padding-bottom: 3px;padding-right: 3px;">
      <a href="news.php?id='.$id.'">komentuj</a> ('.$comments.')
    </td>
  </tr>
</table>
<br>';
}
$tresc .= '
<center>
  [ <b><a href="archive.php">Archiwum newsów</a></b> ]
</center>
';
openTable($title,$tresc);
MenuRight();
closeTable();
closeSite();
?>
