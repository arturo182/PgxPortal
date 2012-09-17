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
if($pgxuser != "") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</b>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
if($pgxuser == "" || $pgxpass == "") {
	echo "Musisz byæ <a href='loginout.php?action=login'>zalogowany</a> by mieæ tutaj dostêp. <a href='member.php?action=reg'>Zarejestruj</a> siê ju¿ teraz!";
	page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
	exit;
}
if($action == "post" && $_POST['submit'] == "") {
	if($quote != "") {
		$query = mysql_query("SELECT * FROM ". $db_prefix ."post WHERE pid='$quote'") or die(mysql_error());
		$post = mysql_fetch_array($query);
		$quote = "[quote=$post[author]]$post[message][/quote]";
	}
	$smileytd = 1;
	$query = mysql_query("SELECT * FROM ". $db_prefix ."smiley ORDER BY sid ASC") or die(mysql_error());
	while($smiley = mysql_fetch_array($query)) {
		if($smileytd == 1) {
$autosmiley .= "
<tr>
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
  ";
  $smileytd = 2;
  } elseif($smileytd == 2) {
  $autosmiley .= "
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
  ";
  $smileytd = 3;
  } elseif($smileytd == 3) {
  $autosmiley .= "
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
  ";
  $smileytd = 4;
  } elseif($smileytd == 4) {
  $autosmiley .= "
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
</tr>
";
			$smileytd = 1;
		}
	}
	$query2 = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE tid='$tid'");
	$topic = mysql_fetch_array($query2);
	$topicn = $topic['name'];
	if($topic['status'] == "2") {
	echo "Ten temat jest zablokowany, nie mo¿esz napisac odpowiedzi.";
	redirectit("topic.php?tid=$tid");
	} else {

	if(!$tid) {
	post_form($pgxuser, $pgxpass, $tid, $fid, $quote, $autosmiley, $topicn, "", "", "post", "","");
	} else {
	post_form($pgxuser, $pgxpass, $tid, $fid, $quote, $autosmiley, $topicn, "", "", "post", "","disabled");
	}
	}
}
if($action == "post" && $_POST['submit'] != "") {
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$tid = $_POST['tid'];
	$fid = $_POST['fid'];
	$pgxuser = $_POST['pgxuser'];
	$pgxpass = $_POST['pgxpass'];
	$message = str_replace("<", "&lt;", $message);
	$message = str_replace(">", "&gt;", $message);
	if(strlen($subject) < 1) {
		echo "Musisz nadaæ nazwê tematowi. <a href=\"javascript: history.go(-1)\" class=\"linkbar\">Popraw to</a>!<br>";
			page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	if(strlen($message) < 10) {
		echo "Pole posta jest puste lub wprowadzono za ma³o znaków. <a href=\"javascript: history.go(-1)\" class=\"linkbar\">Popraw to</a>!<br>";
			page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	$time = time();
	if($fid != "") {
mysql_query("INSERT INTO ". $db_prefix ."topic VALUES ('', '$fid', '$subject', '0', '0', '$time', 'no', '$pgxuser','0')");
$tid = mysql_insert_id();
	}
	if($tid != "") {
		mysql_query("INSERT INTO ". $db_prefix ."post VALUES ('', '$tid', '$subject', '$message', '$pgxuser', '$time')") or die(mysql_error());
		$pid = mysql_insert_id();
		mysql_query("UPDATE ". $db_prefix ."member SET posts=posts+1 WHERE username='$pgxuser'") or die(mysql_error());
		if($fid == "") {
			mysql_query("UPDATE ". $db_prefix ."topic SET replies=replies+1, lastpost='$time' WHERE tid='$tid'") or die(mysql_error());
			$query = mysql_query("SELECT f.fid FROM ". $db_prefix ."forum f, ". $db_prefix ."topic t WHERE f.fid=t.fid AND t.tid='$tid'") or die(mysql_error());
			$fid = mysql_result($query, 0);
		}
		mysql_query("UPDATE ". $db_prefix ."forum SET posts=posts+1, lastpost='$time', postlast='topic.php?tid=$tid#$pid',lastpostauthor='$pgxuser' WHERE fid='$fid'") or die(mysql_error());
	}
	echo "Post zosta³ wys³any. Przenoszê!";
	redirectit("topic.php?tid=$tid#$pid");
}
if($action == "edit" && $_POST['submit'] == "") {
	$query = mysql_query("SELECT author, dateline FROM ". $db_prefix ."post WHERE pid='$pid'") or die(mysql_error());
	$post = mysql_fetch_array($query);
	if($post[author] != $pgxuser && ($userstatus != "Administrator" && $userstatus != "Moderator")) {
		echo "Tylko autor , Admin lub Mod mog± edytowaæ posty. <a href='javascript: history.go(-1)'>Wróæ</a>!<br><br>";
		page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	$query = mysql_query("SELECT message, subject FROM ". $db_prefix ."post WHERE pid='$pid'") or die(mysql_error());
	$pre = mysql_fetch_array($query);
	$smileytd = 1;
	$query = mysql_query("SELECT * FROM ". $db_prefix ."smiley") or die(mysql_error());
	while($smiley = mysql_fetch_array($query)) {
		if($smileytd == 1) {
			$autosmiley .= "
<tr>
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
  ";
  			$smileytd = 2;
  		} elseif($smileytd == 2) {
  			$autosmiley .= "
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
  ";
  			$smileytd = 3;
  		} elseif($smileytd == 3) {
  			$autosmiley .= "
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
  ";
  			$smileytd = 4;
  		} elseif($smileytd == 4) {
  			$autosmiley .= "
  <td>
    <a href=\"javascript:AddText('$smiley[code]')\"><img src=\"image/smiles/$smiley[url]\" alt=\" $smiley[code] \" border=\"0\"></a>
  </td>
</tr>
";
			$smileytd = 1;
		}
	}
if($userstatus == "Administrator" || $userstatus == "Moderator") {
	$deletehtml = "<input type='checkbox' name='delete' value='yes'> Skasowaæ post";
}
	post_form($pgxuser, $pgxpass, $tid, "", $pre[message], $autosmiley, $pre[subject], $pid, "", "edit", $deletehtml,"");
}
if($action == "edit" && $_POST['submit'] != "") {
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$pid = $_POST['pid'];
	$tid = $_POST['tid'];
	$pgxuser = $_POST['nbuser'];
	$pgxpass = $_POST['nbpass'];
	$delete = $_POST['delete'];
	if($delete == "yes" && ($userstatus == "Administrator" || $userstatus == "Moderator")) {
		$query = mysql_query("SELECT lastpost FROM ". $db_prefix ."topic WHERE tid='$tid'");
		$topic = mysql_fetch_array($query);
		mysql_query("DELETE FROM ". $db_prefix ."post WHERE pid='$pid'");
		mysql_query("UPDATE ". $db_prefix ."topic SET replies=replies-1 WHERE tid='$tid'");
		mysql_query("UPDATE ". $db_prefix ."forum SET posts=posts-1 WHERE fid='$forum[fid]'");
		mysql_query("UPDATE ". $db_prefix ."member SET posts=posts-1 WHERE username='$pgxuser'");
		if($topic[lastpost] == $post[dateline]) {
			$query = mysql_query("SELECT dateline FROM ". $db_prefix ."post WHERE tid='$tid' ORDER BY dateline DESC LIMIT 1");
			$newdl = mysql_fetch_array($query);
			mysql_query("UPDATE ". $db_prefix ."topic SET lastpost='$newdl[dateline]' WHERE tid='$tid'");
		}
		if($forum[lastpost] == $post[dateline]) {
			$query = mysql_query("SELECT lastpost FROM ". $db_prefix ."topic WHERE fid='$forum[fid]' ORDER BY lastpost DESC LIMIT 1");
			$newlp = mysql_fetch_array($query);
			mysql_query("UPDATE ". $db_prefix ."forum SET lastpost='$newlp[lastpost]' WHERE fid='$forum[fid]'");
		}
	}
	if($delete == "yes" && ($userstatus != "Administrator" && $userstatus != "Moderator")) {
		echo "Tylko Admin lub Mod mo¿e to zrobiæ. <a href='javascript: history.go(-1)'>Wróæ</a>!";
			page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
		exit;
	}
	mysql_query("UPDATE ". $db_prefix ."post SET subject='$subject', message='$message' WHERE pid='$pid'") or die(mysql_error());
	mysql_query("UPDATE ". $db_prefix ."topic SET name='$subject' WHERE tid='$tid'") or die(mysql_error());
	echo "Zmiany zapisano. Przenoszê!";
	redirectit("topic.php?tid=$tid");
}
page_footer($memcount, $postcount, $onlinecount, $themsg, $fjump);
?>
