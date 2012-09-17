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
$site = "Moderacja";
require "include.php";
include "config.php";
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='../themes/default/gfx/titlebg.gif' width='100%'>
      <b>Moderacja tematu</b>
    </td>
  </tr>
</table>
";
if($userstatus != "Administrator" && $userstatus != "Moderator") {
	echo "Musisz byæ adminem lub modkiem, by móc to zrobiæ.";
	page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
	exit;
}
if($action == "delete" && $HTTP_POST_VARS['submit'] == "") {
echo "
<form method='post' action='toptions.php?action=delete&tid=$tid'>
  <table border='0' cellpadding='4' cellspacing='0' width='60%' align='center'>
    <tr>
      <td width='100%' align='center'>Czy jeste¶ pewny?
      </td>
    </tr>
    <tr>
      <td width='100%' align='center'>Czy napewno chcesz skasowaæ ten temat/post?
      </td>
    </tr>
    <tr>
      <td width='100%' align='center'><input type='submit' name='submit' value='Tak, kasuj'>&nbsp;&nbsp;<input type='button' name='cancel'  value='Nie, anuluj' onClick='history.go(-1)'>
      </td>
    </td>
  </tr>
</table>
</form>
";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
}
if($action == "delete" && $HTTP_POST_VARS['submit'] != "") {
	$query = mysql_query("SELECT fid ". $db_prefix ."FROM topic WHERE tid='$tid'") or die(mysql_error());
	$topic = mysql_fetch_array($query);
	mysql_query("DELETE FROM ". $db_prefix ."topic WHERE tid='$tid'") or die(mysql_error());
	mysql_query("DELETE FROM ". $db_prefix ."post WHERE tid='$tid'") or die(mysql_error());
	$query = mysql_query("SELECT p.* FROM post p, topic t WHERE p.tid=t.tid && t.fid='$topic[fid]'") or die(mysql_error());
	$pcount = mysql_num_rows($query);
	mysql_query("UPDATE ". $db_prefix ."forum SET posts='$pcount' WHERE fid='$topic[fid]'") or die(mysql_error());
	echo "Temat skasowano. Przenoszê!";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
	redirectit("forum.php?fid=$topic[fid]");
}
if($action == "move" && $HTTP_POST_VARS['submit'] == "") {
	$query = mysql_query("SELECT * FROM ". $db_prefix ."forum ORDER BY dorder") or die(mysql_error());
	while($forum = mysql_fetch_array($query)) {
		$forumops .= "<option value='$forum[fid]'>$forum[name]</option>\n";
	}
	echo "
<form method='post' action='toptions.php?action=move&tid=$tid'>
  <table border='0' cellpadding='4' cellspacing='0' width='60%' align='center'>
    <tr>
      <td width='100%' colspan='2' align='center'>Wybierz gdzie.
      </td>
    </tr>
    <tr>
      <td width='100%' colspan='2' align='center'>Wybierz gdzie chcesz przenie¶æ wybrany temat.
      </td>
    </tr>
    <tr>
      <td width='100%' align='center'>Przenie¶ do:&nbsp;<select name='moveto'>$forumops</select>
      </td>
    </tr>
    <tr>
      <td width='100%' align='center' colspan='2'><input type='submit' name='submit' value=' Przenie¶ '>&nbsp;&nbsp;<input type='button' name='cancel'  value=' Anuluj ' onClick='history.go(-1)'>
      </td>
    </td>
  </tr>
</table>
</form>
";
page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
}
if($action == "move" && $HTTP_POST_VARS['submit'] != "") {
	$moveto = $HTTP_POST_VARS['moveto'];
	$query = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE tid='$tid'") or die(mysql_error());
	$topic = mysql_fetch_array($query);
	$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."post WHERE tid='$tid'") or die(mysql_error());
	$pcount = mysql_result($query, 0);
	mysql_query("UPDATE ". $db_prefix ."forum SET posts=posts-$pcount WHERE fid='$topic[fid]'") or die(mysql_error());
	mysql_query("UPDATE ". $db_prefix ."forum SET posts=posts+$pcount WHERE fid='$moveto'") or die(mysql_error());
	mysql_query("UPDATE ". $db_prefix ."topic SET fid='$moveto' WHERE tid='$tid'") or die(mysql_error());
	echo "Temat przeniesiono. Przenoszê!";
	redirectit("forum.php?fid=$moveto");
}
if($action == "lock") {
if($userstatus == "Administrator" || $userstatus == "Moderator") {
	mysql_query("UPDATE ". $db_prefix ."topic SET status='2' WHERE tid='$tid'") or die(mysql_error());
}
	fastredirect("topic.php?tid=$tid");
}
if($action == "top") {
if($userstatus == "Administrator" || $userstatus == "Moderator") {
	mysql_query("UPDATE ". $db_prefix ."topic SET topped='yes' WHERE tid='$tid'") or die(mysql_error());
}
	fastredirect("topic.php?tid=$tid");
}
if($action == "untop") {
if($userstatus == "Administrator" || $userstatus == "Moderator") {
	mysql_query("UPDATE ". $db_prefix ."topic SET topped='no' WHERE tid='$tid'") or die(mysql_error());
}
	fastredirect("topic.php?tid=$tid");
}
if($action == "unlock") {
if($userstatus == "Administrator" || $userstatus == "Moderator") {
	mysql_query("UPDATE ". $db_prefix ."topic SET status='1' WHERE tid='$tid'") or die(mysql_error());
}
	fastredirect("topic.php?tid=$tid");
}
?>
