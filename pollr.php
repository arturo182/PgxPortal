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
$site = "Sonda";
include "include.php";
include "config.php";

$guests = $allow_guests_pool;

if($id && $guests =="1" && !$pgxuser && !$pgxpass)
{
setcookie("pgxpoll", "1");
}

if($id && $pgxuser && $pgxpass)
{
setcookie("pgxpoll", "1");
}

include "themes/$theme/theme.php";

if(!$submit) {
openSite("Wyniki sondy");
MenuLeft();
$title = "Wyniki sondy";
$tresc = "
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
  ";
  $result = mysql_query("SELECT * FROM ". $db_prefix ."poll_title WHERE active='on' ORDER BY id");
  while ($myrow = mysql_fetch_array($result)){
  $myrow['title'] = stripslashes($myrow['title']);
  $naslov = $myrow['id'];
  $tresc .= "
  <tr>
    <td align='center'>
      <strong>".$myrow['title']."</strong>
    </td>
  </tr>
  ";
  }
  if(mysql_num_rows($result) == 0) {
  $tresc .= "
  <tr>
    <td align='center'>
      <strong>Aktualnie nie jest prowadzona ¿adna ankieta.</strong>
    </td>
  </tr>
  ";
  $glosy = "nie";
  }
  $result2 = mysql_query("SELECT number FROM ". $db_prefix ."poll WHERE title='$naslov'");
  $all = "0";
  while ($myrow = mysql_fetch_array($result2)){
  $all = $all + $myrow['number'];
  }
  $result2 = mysql_query("SELECT * FROM ". $db_prefix ."poll WHERE title='$naslov'");
  $tresc .=  "
  <tr>
    <td align='center'><br>
      <table border='0' cellpadding='1' cellspacing='0'>
        ";
        while ($myrow = mysql_fetch_array($result2)){
        if ($all != "" OR "0") {
        $number = ceil(($myrow['number'] / $all)*100);
        }
        $number2 = 150 - $number;
        $myrow['content'] = stripslashes($myrow['content']);
        $tresc .=  "
        <tr>
          <td width='30%'>
            " . $myrow['content'] . "
          </td>
          <td width='60%'>
            <img src='themes/$theme/gfx/poll1.gif' width='".$number."' height='10'><img src='themes/$theme/gfx/poll2.gif' width='".$number2."' height='10'><img src='themes/".$theme."/gfx/poll1.gif' width='1' height='10'> ".$number."% (".$myrow['number'].")
          </td>
        </tr>
        ";
        }
        $tresc .=  "
        <tr>
          <td colspan='2' align='center'>
            ";
            if($glosy != "nie"){
            $tresc .=  "Razem g³osów: <b>".$all."</b>";
            }
            $tresc .=  "
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
";
if($nli == "1")
{
$tresc .=  "<br>
<center>
  <b>Tylko <a href='member.php?action=reg'>zarejestrowani</a> i <a href='loginout.php?action=login'>zalogowani</a> u¿ytkownicy mog± g³osowaæ!</b>
</center>
";
}
openTable($title,$tresc);
MenuRight();
closeTable();
closeSite();
} else {
if (!$pgxuser && $guests == "0") {
echo '<script>window.location.replace("pollr.php?nli=1")</script>';
} else {
if (isset($id)) {
if(!$_COOKIE ['pgxpoll']) {
mysql_query("UPDATE ". $db_prefix ."poll SET number=number+1 WHERE id='$id'");
$result = mysql_query("SELECT * FROM ". $db_prefix ."poll_title ORDER BY id desc LIMIT 1");
while ($myrow = mysql_fetch_array($result)){
$id = $myrow['id'];
}
echo '<script>window.location.replace("pollr.php")</script>';
exit;
}
else
{
echo '<script>window.location.replace("pollr.php")</script>';
exit;
}
} else {
echo '<script>window.location.replace("pollr.php")</script>';
exit;
}
}
}
?>
