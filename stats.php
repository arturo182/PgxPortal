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
$site = "Panel Admina";
require "include.php";
include "config.php";
$guests = $allow_guests_stats;
include "themes/$theme/theme.php";
openSite("Statystyki strony");
MenuLeft();
if($guests == "0" && $userstatus != "Administrator") {
$tresc = "<b>Statystyki widoczne tylko dla administratorów</b>";
} else {
$tresc = '<b>Procenty s± zaokr±glane, wiêc nie zawsze ich suma bêdzie wynosiæ 100, czasami mo¿e to byæ wiêcej ni¿ 100, a czasami mniej.</b>
<br><br>
<b>Przegl±darki:</b>
<bR>
<center>
  <table>
    ';
    $query = mysql_query("SELECT * FROM ". $db_prefix ."stats") or die(mysql_error());
    while($stats = mysql_fetch_array($query)){
    $counter = $stats['counter'];
    $msie = $stats['msie'];
    $opera = $stats['opera'];
    $mozilla = $stats['mozilla'];
    $other = $stats['other'];
    $win98 = $stats['win98'];
    $winxp = $stats['winxp'];
    $linux = $stats['linux'];
    $osther = $stats['osther'];
    }
    if ($counter != "0" && $msie != "0") {
    $procmsie = ceil(($msie / $counter)*100);
    } else {
    $procmsie = "0";
    }
    $ie = $procmsie*4;
    $ie2 = 400 - $ie;
    $tresc .='
    <tr>
      <td width="10">
        <img src="image/stats/msie.gif" alt="Microsoft Internet Explorer" title="Microsoft Internet Explorer">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$ie.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$ie2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$procmsie.'% ('.$msie.')
      </td>
    </tr>
    ';
    if ($counter != "0" && $opera != "0") {
    $procope = ceil(($opera / $counter)*100);
    } else {
    $procope = "0";
    }
    $op = $procope*4;
    $op2 = 400 - $op;
    $tresc .='
    <tr>
      <td width="10">
        <img src="image/stats/opera.gif" alt="Opera" title="Opera">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$op.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$op2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$procope.'% ('.$opera.')
      </td>
    </tr>
    ';
    if ($counter != "0" && $mozilla != "0") {
    $procmoz = floor(($mozilla / $counter)*100);
    } else {
    $procmoz = "0";
    }
    $mo = $procmoz*4;
    $mo2 = 400 - $mo;
    $tresc .='
    <tr>
      <td width="10">
        <img src="image/stats/mozilla.gif" alt="Mozilla" title="Mozilla">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$mo.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$mo2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$procmoz.'% ('.$mozilla.')
      </td>
    </tr>
    ';
    if ($counter != "0" && $other != "0") {
    $procoth = floor(($other / $counter)*100);
    } else {
    $procoth = "0";
    }
    $ot = $procoth*4;
    $ot2 = 400 - $ot;
    $procall = $procmoz + $procoth + $procmsie + $procope;
    $tresc .= '
    <tr>
      <td width="10">
        <img src="image/stats/other.gif" alt="Inne" title="Inne">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$ot.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$ot2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$procoth.'% ('.$other.')
      </td>
    </tr>
    ';
    $tresc .= '
    <tr>
      <td width="10">
        &nbsp;
      </td>
      <td align="right">
        <b>razem:</b>
      </td>
      <td width="80" align="right">
        '.$procall.'% ('.$counter.')
      </td>
    </tr>
    ';
    $tresc .= "
  </table>
</center>
<br><br>
<b>Systemy operacyjne:</b>
<br>
<center>
  <table>
    ";
    if ($counter != "0" && $win98 != "0") {
    $proc98 = ceil(($win98 / $counter)*100);
    } else {
    $proc98 = "0";
    }
    $w98 = $proc98*4;
    $w99 = 400 - $w98;
    $tresc .='
    <tr>
      <td width="10">
        <img src="image/stats/win98.gif" alt="Microsoft Windows 98" title="Microsoft Windows 98">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$w98.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$w99.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$proc98.'% ('.$win98.')
      </td>
    </tr>
    ';
    if ($counter != "0" && $winxp != "0") {
    $procxp = ceil(($winxp / $counter)*100);
    } else {
    $procxp = "0";
    }
    $xp = $procxp*4;
    $xp2 = 400 - $xp;
    $tresc .='
    <tr>
      <td width="10">
        <img src="image/stats/winxp.gif" alt="Microsoft Windows XP" title="Microsoft Windows XP">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$xp.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$xp2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$procxp.'% ('.$winxp.')
      </td>
    </tr>
    ';
    if ($counter != "0" && $linux != "0") {
    $proclin = floor(($linux / $counter)*100);
    } else {
    $proclin = "0";
    }
    $li = $proclin*4;
    $li2 = 400 - $li;
    $tresc .='
    <tr>
      <td width="10">
        <img src="image/stats/linux.gif" alt="Linux" title="Linux">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$li.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$li2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$proclin.'% ('.$linux.')
      </td>
    </tr>
    ';
    if ($counter != "0" && $osther != "0") {
    $procosth = floor(($osther / $counter)*100);
    } else {
    $procosth = "0";
    }
    $ost = $procosth*4;
    $ost2 = 400 - $ot;
    $procall = $procxp + $procsoth + $proclin + $proc98;
    $tresc .= '
    <tr>
      <td width="10">
        <img src="image/stats/other.gif" alt="Inne" title="Inne">&nbsp;
      </td>
      <td align="center">
        <img src="themes/'.$theme.'/gfx/poll1.gif" width="'.$ost.'" height="10"><img src="themes/'.$theme.'/gfx/poll2.gif" width="'.$ost2.'" height="10"><img src="themes/'.$theme.'/gfx/poll1.gif" width="1" height="10">
      </td>
      <td width="80" align="right">
        '.$procosth.'% ('.$osther.')
      </td>
    </tr>
    ';
    $tresc .= '
    <tr>
      <td width="10">
        &nbsp;
      </td>
      <td align="right">
        <b>razem:</b>
      </td>
      <td width="80" align="right">
        '.$procall.'% ('.$counter.')
      </td>
    </tr>
    ';
    $tresc .= "
  </table>
</center>
";
}
openTableMini("Statystyki",$tresc);
closeTableMini();
closeSite();
?>
