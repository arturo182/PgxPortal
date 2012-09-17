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
page_header("- <a href='privmsg.php'>Wiadomo¶ci [<b>$numrows</B>]</a> - <a href='loginout.php?action=logout'>Wyloguj</a>", $themsg, $title,"");
} else {
page_header("- <a href='member.php?action=reg'>Rejestracja</a>", $themsg, $title,"");
}
echo "
<table border='0' cellpadding='3' cellspacing='0' width='100%' align='center'>
  <tr>
    <td background='themes/$theme/gfx/titlebg.gif' width='100%' height='21'>
      <b>Forum</b>
    </td>
  </tr>
</table>
<table style='padding-left: 10px; padding-right: 10px'; width='100%'>
  <tr>
    <td>
      <table cellpadding='0' cellspacing='0' width='100%'>
        <tr>
          <td width='100%'>
            <table width='100%' style='border: 1px solid #1c1c1c;';>
              <tr>
                <td>
                  <table border='0' cellpadding='3' cellspacing='0' width='100%'>
                    <tr>
                      <td background='themes/$theme/gfx/titlebg.gif' width='60%'><b><a href='forumi.php?order=name&esc=asc'>Dzia³</a></b></td>
                      <td background='themes/$theme/gfx/titlebg.gif' width='10%' align='center' height='20'><b>Tematów</b></td>
                      <td background='themes/$theme/gfx/titlebg.gif' width='10%' align='center' height='20'><b>Postów</b></td>
                      <td background='themes/$theme/gfx/titlebg.gif' width='20%' align='center' height='20'><b>Ostatni post</b></td>
                    </tr>
                  </table>
                  <table border='0' cellpadding='3' cellspacing='0' width='100%'>
                    ";
                $ttnum = 1;
                $query_db = mysql_num_rows(mysql_query("SELECT * FROM ". $db_prefix ."forum"));
                if($query_db == "0")
                {
                echo "
                    <tr>
                      <td background='themes/$theme/gfx/bg$ttnum.gif' width='100%' colspan='4'>Brak dzia³ów</td>
                   </tr>
                ";
                }
                else
                {
                    
                    $query = mysql_query("SELECT * FROM ". $db_prefix ."forum") or die(mysql_error());
                    while($forum = mysql_fetch_array($query)) {
                    
                    
                    $count_topics = mysql_num_rows(mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE fid='$forum[fid]'"));
                    	if($forum[lastpost] != 0) {
                    		$forum[lastpost] = $datetime = datepl(date("d-m-Y H:i", $forum[lastpost]));
                    	} else {
                    		$forum[lastpost] = "Nigdy";
                    	}
                    	
                    	$query_id_user = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$forum[lastpostauthor]'");
                        $result_id_user = mysql_fetch_array($query_id_user);
                    	
                    echo "
                    <tr>
                      <td background='themes/$theme/gfx/bg$ttnum.gif' width='60%'><a href='forum.php?fid=$forum[fid]'><b>$forum[name]</b></a><br>$forum[description]</td>
                      <td background='themes/$theme/gfx/bg$ttnum.gif' width='10%' align='center'>$count_topics</td>
                      <td background='themes/$theme/gfx/bg$ttnum.gif' width='10%' align='center'>$forum[posts]</td>
                      <td background='themes/$theme/gfx/bg$ttnum.gif' width='20%' align='center'>$forum[lastpost]";
                        if($forum[lastpostauthor]){
                        echo "<br><a href='member.php?action=viewpro&member=$result_id_user[uid]'>$forum[lastpostauthor]</a> <a href='$forum[postlast]'><img src='themes/$theme/gfx/right.gif' border='0'></a>";
                        }
                      echo "</td>
                    </tr>
                    ";
                    }
                    	$ttnum = altcolors($ttnum);
                    }
                    echo "
                  </table>
                  <table width='100%'>
                    <tr>
                      <td background='themes/$theme/gfx/titlebg.gif' width='100%' height='3'>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>";
$new = mysql_query("SELECT * FROM ". $db_prefix ."member ORDER BY `regdate` DESC  LIMIT 1");
while($newe = mysql_fetch_array($new)) {
$newest_id = $newe['uid'];
$newest = $newe['username'];
}
$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online WHERE name='guest'") or die(mysql_error());
$onlineg = mysql_result($query, 0);
$query = mysql_query("SELECT COUNT(*) FROM ". $db_prefix ."online WHERE name!='guest'") or die(mysql_error());
$onlineu = mysql_result($query, 0);
$query = mysql_query("SELECT * FROM ". $db_prefix ."online WHERE name!='guest'") or die(mysql_error());
if(mysql_num_rows($query) == "0") {
$online .= "<i>brak</i>";
}
if(mysql_num_rows($query) > "1") {
$query = mysql_query("SELECT * FROM ". $db_prefix ."online WHERE name!='guest' LIMIT 1") or die(mysql_error());
while($onl = mysql_fetch_array($query)) {
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$onl[name]'");
$result = mysql_fetch_array($query);
$status = $result['status'];
if($status == "Administrator") {
$online .= "<a href='member.php?action=viewpro&member=$onl[uid]'>@$onl[name]</a>";
}
elseif($status == "Moderator") {
$online .= "<a href='member.php?action=viewpro&member=$onl[uid]'>$$onl[name]</a>";
} else {
$online .= "<a href='member.php?action=viewpro&member=$onl[uid]'>$onl[name]</a>";
}
}
$query2 = mysql_query("SELECT * FROM ". $db_prefix ."online WHERE name!='guest' LIMIT 1,99999999999999999999999999999999999999") or die(mysql_error());
while($onl = mysql_fetch_array($query2)) {
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$onl[name]'");
$result = mysql_fetch_array($query);
$status = $result['status'];
if($status == "Administrator") {
$online .= "<a href='member.php?action=viewpro&member=$result[uid]'>, <font color=\"red\">$onl[name]</font></a>";
}
elseif($status == "Moderator") {
$online .= "<a href='member.php?action=viewpro&member=$result[uid]'>, <font color=\"green\">$onl[name]</font></a>";
} else {
$online .= "<a href='member.php?action=viewpro&member=$result[uid]'>, $onl[name]</a>";
}
}
} else {
$query = mysql_query("SELECT * FROM ". $db_prefix ."online WHERE name!='guest'") or die(mysql_error());
while($onl = mysql_fetch_array($query)) {
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$onl[name]'");
$result = mysql_fetch_array($query);
$status = $result['status'];
if($status == "Administrator") {
$online .= "<a href='member.php?action=viewpro&member=$result[uid]'><font color=\"red\">$onl[name]</font></a>";
}
elseif($status == "Moderator") {
$online .= "<a href='member.php?action=viewpro&member=$result[uid]'><font color=\"green\">$onl[name]</font></a>";
} else {
$online .= "<a href='member.php?action=viewpro&member=$result[uid]'>$onl[name]</a>";
}
}
}
echo "
<table style='padding-left: 10px; padding-right: 10px'; width='100%'>
  <tr>
    <td>
      <table style='border: 1px solid #1c1c1c;' width='100%'>
        <tr>
          <td height='21' align='left' background='themes/$theme/gfx/titlebg.gif' style='padding-left: 6px;'>
            <strong>Statystyki</strong>
          </td>
        </tr>
        <tr>
          <td style='padding-left: 10px;'>
            Nasi u¿ytkownicy napisali <b>$postcount</b> postów w <b>$topic_count</b> tematach<br>
            Mamy $memcount zarejestrowanych u¿ytkowników<br>
            Ostatnio zarejestrowa³(a) siê <a href='member.php?action=viewpro&member=$newest_id'>$newest</a><br>";
            if($onlinecount != 1) { $users = 'osób'; } else { $users = 'osoba'; }
            if($onlineu != 1) { $userm = 'u¿ytkowników'; } else { $userm = 'u¿ytkownik'; }
            if($onlineg != 1) { $userg = 'go¶ci'; } else { $userg = 'go¶æ'; }
            echo "Na forum jest $onlinecount $users :: $onlineu $userm i $onlineg $userg (<b><font color=\"red\">Administator</font> <font color=\"green\">Moderator</font>)</b><br>
            Zarejestrowani u¿ytkownicy: $online
          </td>
        </tr>
      </form>
    </table>
  </td>
</tr>
</table>
";
page_footer();
?>
