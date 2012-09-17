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
require "include.php";
include "config.php";
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
$query2 = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE tid='$tid'");
$topic = mysql_fetch_array($query2);
if($topic['status'] == "2") {
} else {
$addt = "
<table cellspacing='10'>
  <tr>
    <Td><a href='post.php?action=post&tid=$tid'><img src='themes/$theme/gfx/addr.gif' border='0'></a>
    </td>
  </tr>
</table>
";
}
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"$addt");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
echo "&nbsp;<a href='index.php'><b>$sitename</b></a>";
echo " &gt; <a href='forumi.php'><b>Forum</b></a>";
$resultt = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE tid='$tid'");
$topic = mysql_fetch_array($resultt);
$resultf = mysql_query("SELECT * FROM ". $db_prefix ."forum WHERE fid='$topic[fid]'");
$forum = mysql_fetch_array($resultf);
echo " &gt; <a href='forum.php?fid=".$topic[fid]."'><b>".$forum[name]."</b></a>";
echo " &gt; <b>".$topic[name]."</b>";
$query = mysql_query("SELECT * FROM ". $db_prefix ."config") or die(mysql_error());
$result = mysql_fetch_array($query);
$perpage = $result[maxrep];
if($page == "") {
	$page = 1;
	$start = 0;
} else {
	$start = ($page - 1) * $perpage;
}
$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."post WHERE tid='$tid'") or die(mysql_error());
$pcount = mysql_result($query, 0);
$multi = multipage($pcount, $perpage, $page, "topic.php?tid=$tid");
$ttnum = 1;
mysql_query("UPDATE ". $db_prefix ."topic SET views=views+1 WHERE tid='$tid'") or die(mysql_error());
$query = mysql_query("SELECT p.*, m.* FROM ". $db_prefix ."post p, ". $db_prefix ."member m WHERE p.tid='$tid' AND m.username=p.author ORDER BY dateline LIMIT $start, $perpage") or die(mysql_error());
while($post = mysql_fetch_array($query)) {
	$post[message] = postify(wordwrap($post[message] ,65, ' ', 1));
	$post[dateline] = $datetime = datepl(date("d-m-Y H:i", $post[dateline]));
	$post[regdate] = $datetime = datepl(date("d-m-Y", $post[regdate]));
	if($post[subject] != "") {
	$post[subject] = "<i>$post[subject]</i><br />";
	} else {
	$post[subject] = "<i>nie podano</i><br />";
}
	if($post[sig] != "") {
		$post[message] = "$post[message] <br>_________________<br>$post[sig]";
	} else {
		$post[message] = "$post[message]";
}
	if($userstatus == "Administrator" || $userstatus == "Moderator") {
		if($topic['status'] == "2") {
		$lock = "unlock";
		$bl = "Od";
		} else {
		$lock = "lock";
		$bl = "Za";
		}
		if($topic['topped'] == "yes") {
		$top = "untop";
		$bt = "Od";
		} else {
		$top = "top";
		$bt = "Przy";
		}
		$mod = "<a href='toptions.php?action=delete&tid=$tid'>Kasuj</a> - <a href='toptions.php?action=move&tid=$tid'>Przenie¶</a> - <a href='toptions.php?action=$lock&tid=$tid'>" . $bl . "blokuj</a> - <a href='toptions.php?action=$top&tid=$tid'>" . $bt . "klej</a>";
	}
$userq = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='" . $post['author'] . "'");
$user = mysql_fetch_array($userq);
	echo "<a id='$post[pid]'></a>
<table style='border-top: 1px solid #1c1c1c; border-bottom: 1px solid #1c1c1c' width='704' colspan='0' cellspacing='0'>
  <tr>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='20%' align='left' valign='top' style='padding-left: 2px;'>
      <b><a href='member.php?action=viewpro&member=$user[uid]'>$post[author]</a></b>
      <br>$post[status]<br>";
      if($user[yahoo] != "") {
      echo "<img src='$user[yahoo]'>";
      }
      echo" <br>
      <br>Postów: $post[posts]
      <br>Sk±d: $user[location]
    </td>
    <td width='80%' height='28' valign='top'>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td width='100%' background='themes/$theme/gfx/bg$ttnum.gif'>
            Napisano: $post[dateline] Temat: $post[subject]
          </td>
          <td nowrap='nowrap' background='themes/$theme/gfx/bg$ttnum.gif'>
            ";
            $cookie = explode(" ",$_COOKIE["pgxuser"]);
            if($cookie[0] == $post[author] || $userstatus == "Administrator" || $userstatus == "Moderator") {
            echo "<a href='post.php?action=edit&tid=$tid&pid=$post[pid]'><img src='themes/$theme/gfx/edit.gif' border='0'></a>&nbsp;";
            }
            echo "<a href='post.php?action=post&tid=$tid&quote=$post[pid]'><img src='themes/$theme/gfx/quote.gif' border='0'></a>&nbsp;
          </td>
        </tr>
        <tr>
          <td colspan='2' style='padding-left: 5px; padding-top: 5px;'>
            $post[message]
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td background='themes/$theme/gfx/bg$ttnum.gif' width='150' align='left' valign='middle'>
      <a href='#top'>Powrót do góry</a>
    </td>
    <td  width='100%' height='28' valign='bottom' nowrap='nowrap'>
      <table cellspacing='0' cellpadding='0' border='0' height='18' width='18'>
        <tr>
          <td valign='middle' nowrap='nowrap'>
            ";
            if($user['website'] != "") {
            echo "<a href='$user[website]' target='_blank'><img src='themes/$theme/gfx/home.gif' border='0'></a>";
            }
            if($user['aim'] != "") {
            echo "&nbsp;
            <span style='position:relative'>
              <img src='themes/$theme/gfx/gg.gif' border='0'>
              <span style='position:absolute;left:3px;top:-1px'>
                <a href='GG:$user[aim]'><img src='http://www.gadu-gadu.pl/users/status.asp?id=$user[aim]&styl=1' border='0'></a>
              </span>
            </span>
            ";
            }
            if($user['msn'] != "") {
            echo "&nbsp;
            <span style='position:relative'>
              <img src='themes/$theme/gfx/tlen.gif' border='0'>
              <span style='position:absolute;left:3px;top:-1px'>
                <a href='$user[msn]'><img src='http://status.tlen.pl/?u=$user[msn]&t=1' border='0'></a>
              </span>
            </span>
            ";
            }
            echo "
          </td>
        </tr>
      </table>
    </td>
    <tr>
    </table>
    <br>";
    	$ttnum = altcolors($ttnum);
    }
    topic_footer($multi, $tid, $mod,$addt);
    page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
?>
