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
$site = "Artyku造";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
openSite("Artyku造");
MenuLeft();
if (isset($id)) {
$query = mysql_query("SELECT * FROM ". $db_prefix ."articles WHERE id='$id'");
while($article=mysql_fetch_array($query)){
$tresc = postify($article['text']);
$title = $article['title'];
$date = $article['date'];
}
}
elseif(isset($fid))  {
if(isset($_GET['order']) && isset($_GET['esc'])) {
$what1 = $_GET['order'];
$what2 = $_GET['esc'];
} else {
$what1 = "id";
$what2 = "desc";
}
$fol = mysql_query("SELECT * FROM ". $db_prefix ."articles_folders WHERE id=$fid");
$folder=mysql_fetch_array($fol);
$query = mysql_query("SELECT * FROM ". $db_prefix ."articles WHERE folder=$fid ORDER BY $what1 $what2");
$title = 'Artyku造 -> '.$folder[name];
$tresc .= '
<center>
  sortuj wed逝g: tytu逝 <a href="articles.php?fid='.$fid.'&order=title&esc=asc"><img src="themes/'.$theme.'/gfx/up.gif" border="0"></a> <a href="articles.php?fid='.$fid.'&order=title&esc=desc"><img src="themes/'.$theme.'/gfx/down.gif" border="0"></a> | daty <a href="articles.php?fid='.$fid.'&order=date&esc=asc"><img src="themes/'.$theme.'/gfx/up.gif" border="0"></a> <a href="articles.php?fid='.$fid.'&order=date&esc=desc"><img src="themes/'.$theme.'/gfx/down.gif" border="0"></a>
</center>
<br>';
if(mysql_num_rows($query) == "0") {
$tresc .= 'Nie ma 瘸dnych artyku堯w w tej kategorii.';
} else{
while($article=mysql_fetch_array($query)){
$id = $article['id'];
$title2 = $article['title'];
$tekst = $article['text'];
$date = datepl(date("d-m-Y  H:i", $article['date']));
$tresc .= '
<table style="border: 1px solid $border;" bgcolor="'.$bgcom.'" width="390" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="left" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left:6px;" colspan="2">
      ';
      if($userstatus == "Administrator") {
      $tresc .= '<a href="admin.php?mode=articles&action=deletef&id='.$id.'#bottom">[U]</a> <a href="admin.php?mode=articles&action=editf&id='.$id.'#bottom">[E]</a>&nbsp;';
      }
      $tresc .= '<strong>'.$title2.'</strong>
    </td>
  </tr>
  <tr>
    <td style="padding: 6px; text-align : justify;" colspan="2">
      '.postify(shorter($tekst, 260)) .'
    </td>
  </tr>
  <tr>
    <td background="themes/'.$theme.'/gfx/titlebg2.gif" style="border-top: 1px solid '.$border.';padding-top: 3px;padding-bottom: 3px;padding-right: 3px;padding-left: 3px;">
      Napisano: '.$date.'
    </td>
    <td valign="top" background="themes/'.$theme.'/gfx/titlebg2.gif" align="right" style="border-top: 1px solid '.$border.';padding-top: 3px;padding-bottom: 3px;padding-right: 3px;">
      <a href="articles.php?id='.$id.'">Czytaj...&nbsp;</a>
    </td>
  </tr>
</table>
<br>';
}
}
} else {
$title = 'Artyku造';
$fol = mysql_query("SELECT * FROM ". $db_prefix ."articles_folders");
if(mysql_num_rows($fol) == 0){
$tresc .= '
<center>
  <b>Brak kategorii.</b>
</center>
';
} else {
while($folder=mysql_fetch_array($fol)){
$tresc .= '
<table style="border: 1px solid '.$border.'" bgcolor="'.$bgcom.'" width="390" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" align="left" background="themes/'.$theme.'/gfx/titlebg2.gif" style="padding-left:6px;" colspan="2">
      ';
      if($userstatus == "Administrator") {
      $tresc .= '<a href="admin.php?mode=articles&action=delete&id=' . $folder[id] . '#bottom">[U]</a> <a href="admin.php?mode=articles&action=edit&id=' . $folder[id] . '#bottom">[E]</a>&nbsp;';
      }
      $tresc .= '<strong><a href="articles.php?fid='.$folder[id].'">'.$folder[name].'</a></strong>
    </td>
    <td align="right" background="themes/'.$theme.'/gfx/titlebg2.gif">
      Artyku堯w: <b>' . mysql_num_rows(mysql_query("SELECT * FROM articles WHERE folder=$folder[id]")) . '</b>&nbsp;
    </td>
  </tr>
  <tr>
    <td style="padding: 6px; text-align : justify;" colspan="2" bgcolor="'.$bgcom.'">
      '.$folder[description].'
    </td>
  </tr>
</table>
<br>';
}
}
}
openTable($title,$tresc);
MenuRight();
closeTable();
closeSite();
?>
