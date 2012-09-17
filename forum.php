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
$site = "Forum";
include "include.php";
include "config.php";
if($fid == "main") {
	fastredirect("forumi.php");
}
$addt = "
<table cellspacing='10'>
  <tr>
    <td>
      <a href=\"post.php?action=post&fid=$fid\"><img src='themes/$theme/gfx/addt.gif' border='0'></a>
    </td>
  </tr>
</table>";
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"$addt");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."config") or die(mysql_error());
$result = mysql_fetch_array($query);
$perpage = $result['maxtop'];
if($page == "") {
	$page = 1;
	$start = 0;
} else {
	$start = ($page - 1) * $perpage;
}
$resultf = mysql_query("SELECT * FROM ". $db_prefix ."forum WHERE fid='$fid'");
$forum = mysql_fetch_array($resultf);
echo "&nbsp;<a href='index.php'><b>$sitename</b></a>";
echo " &gt; <a href='forumi.php'><b>Forum</b></a>";
echo " &gt; <b>".$forum[name]."</b><br><br>";
$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."topic WHERE fid='$fid'") or die(mysql_error());
$tcount = mysql_result($query, 0);
$multi = multipage($tcount, $perpage, $page, "forum.php?fid=$fid");
echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' height='20'>
    </td>
    <td background='themes/$theme/gfx/titlebg.gif' width='50%' height='20'>&nbsp;<a href='forum.php?fid=$fid&order=name&esc=asc'>Tematy</a></td>
    <td background='themes/$theme/gfx/titlebg.gif' width='12%' height='20'><a href='forum.php?fid=$fid&order=author&esc=asc'>Autor</a></td>
    <td background='themes/$theme/gfx/titlebg.gif' align='center' width='8%' height='20'><a href='forum.php?fid=$fid&order=replies&esc=asc'>Odpowiedzi</a></td>
    <td background='themes/$theme/gfx/titlebg.gif' align='center' width='8%' height='20'><a href='forum.php?fid=$fid&order=views&esc=asc'>Ods³on</a></td>
    <td background='themes/$theme/gfx/titlebg.gif' align='center' width='22%' height='20'><a href='forum.php?fid=$fid'>Ostatni Post</a></td>
  </tr>
  ";
  $ttnum = 1;
  if(isset($_GET['order']) && isset($_GET['esc'])) {
  $what1 = $_GET['order'];
  $what2 = $_GET['esc'];
  } else {
  $what1 = "lastpost";
  $what2 = "desc";
  }
  $query = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE fid='$fid' AND topped='yes' ORDER BY $what1 $what2 LIMIT $start, $perpage") or die(mysql_error());
  while($topic = mysql_fetch_array($query)) {
  
  
  $users_id = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username = '$topic[author]'"));
  $topic[lastpost] = datepl(date("d-m-Y, H:i", $topic[lastpost]));
  echo"
  <tr>
    <td background='themes/$theme/gfx/bg$ttnum.gif' height='24'><img src='image/topic_topped.gif'alt='Temat przyklejony'>";
      $querya = mysql_query("SELECT * FROM post WHERE tid='$topic[tid]' ORDER BY pid DESC") or die(mysql_error());
      $author = mysql_fetch_array($querya);
      echo "
    </td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='50%' height='24'><a href='topic.php?tid=$topic[tid]'>$topic[name]</a></td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='12%' height='24'><a href='member.php?action=viewpro&member=$users_id[0]'>$topic[author]</a></td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='8%' align='center' height='24'>$topic[replies]</td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='8%' align='center' height='24'>$topic[views]</td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='22%' align='center' height='4'>$topic[lastpost]<br> <a href='member.php?action=viewpro&member=$users_id[0]'>$author[author]</a> <a href='topic.php?tid=$topic[tid]#$author[pid]'><img src='themes/$theme/gfx/right.gif' border='0'></a></td>
  </tr>
  ";
  $ttnum = altcolors($ttnum);
  }
  $query = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE fid='$fid' AND topped='no' ORDER BY $what1 $what2 LIMIT $start, $perpage") or die(mysql_error());
  while($topic = mysql_fetch_array($query)) {
  	$topic[lastpost] = datepl(date("d-m-Y, H:i", $topic[lastpost]));
  	echo"
  <tr>
    <td background='themes/$theme/gfx/bg$ttnum.gif' height='24' >
      ";
      	if($topic['status'] == "2") {
      	echo "<img src='image/topic_locked.gif' alt='$topic[name]'>";
      	} else {
      	echo "<img src='image/topic_default.gif'alt='Temat zablokowany'>";
      	}
      	$querya = mysql_query("SELECT * FROM ". $db_prefix ."post WHERE tid='$topic[tid]' ORDER BY pid DESC") or die(mysql_error());
      	$author = mysql_fetch_array($querya);
         $users_id = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username = '$author[author]'"));
      echo "
    </td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='50%' height='24'><a href='topic.php?tid=$topic[tid]'>$topic[name]</a></td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='12%' height='24'><a href='member.php?action=viewpro&member=$users_id[0]'>$topic[author]</a></td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='8%' align='center' height='24'>$topic[views]</td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='8%' align='center' height='24'>$topic[replies]</td>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='22%' align='center' height='4'>$topic[lastpost]<br> <a href='member.php?action=viewpro&member=$users_id[0]'>$author[author]</a> <a href='topic.php?tid=$topic[tid]#$author[pid]'><img src='themes/$theme/gfx/right.gif' border='0'></a>
    </td>
  </tr>
  ";
  	$ttnum = altcolors($ttnum);
  }
  if($pgxuser != "") {
  forum_footer($multi,$addt);
  } else{
  forum_footer($multi,"");
  }
  page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
?>
