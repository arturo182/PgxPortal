<?
include "config.php";
$time = time();
$date = $time-86400;
if($_POST['shoutsubmit'] == '')
{
 $query = mysql_query("SELECT * FROM ". $db_prefix ."shoutbox");
 $lol = mysql_num_rows($query);
  if($lol <= "10")
   {
    $limit = "0";
   }
   else
   {
    $limit = $lol-10;
   }

 $query = mysql_query("SELECT * FROM ". $db_prefix ."shoutbox ORDER BY `date` ASC LIMIT $limit,10");
 $num = "0";
 echo '<table width="90%">';

 while($shout = mysql_fetch_array($query))
 {
  $get_user = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE uid='$shout[author]'"));

  if($get_user[username] == "")
  {
   $show_who_write = '~'.$shout[author];
  }
   else
  {
   $show_who_write = '<a href="member.php?action=viewpro&member='. $shout[author] .'">'.$get_user[username].'</a>';
  }

   echo '<tr><td background="themes/'.$sname.'/gfx/bg2.gif">['. shout(date("d-w- H:i", $shout[date])) .'] <b>'. $show_who_write .':</b> '. postify($shout[text]) .'</td></tr>';
}

echo '<tr><td><form action="index.php" method="post"><table><tr><td>';

if(!$pgxuser)
{
 echo '<input type="text" name="author"><br></td></tr><tr><td>';
}
else
{
 echo '<input type="text" name="author" value="'.$pgxuser.'" disabled><input type="hidden" name="author" value="'.$pgxuser.'"><br></td></tr><tr><td>';
}

echo '<textarea name="text" cols="20" rows="5"></textarea></td></tr></table></td></tr><tr><td valign="top"><input type="submit" name="shoutsubmit" value="Go!"> <input type="button" value="Od¶wie¿" OnClick="javascript: window.location.reload()"></td></tr></table>';


}
else
{
if(!eregi("[0-9]", $_POST[author]))
{
 $query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$_POST[author]'");
  if(mysql_num_rows($query) == "1" && $pgxuser != $_POST[author])
  {
   echo '<script>window.location.replace("index.php?snotify='.$_POST[author].'")</script>';
  }
  else
  {
   if($_POST['text'] != '' && $_POST['text'] != '')
    {
     $time = time();
     if($pgxuser)
     {
      $get_user_id = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$_POST[author]'"));
      mysql_query("INSERT INTO ". $db_prefix ."shoutbox (id, author, text, date) VALUES ('', '$get_user_id[uid]', '$_POST[text]', '$time')");
     }
     else
     {
      mysql_query("INSERT INTO ". $db_prefix ."shoutbox (id, author, text, date) VALUES ('', '$_POST[author]', '$_POST[text]', '$time')");
     }
    }
     echo '<script>window.location.replace("index.php")</script>';
   }
}
else
{
echo "Wpisz swój nick";
}
}

if($_GET[snotify] != "")
{
 echo '<br><center><b>U¿ytkownik o takim nicku istnieje, je¶li ty jeste¶ '.$_GET[snotify].', to zaloguj siê by dodaæ komentarz pod swoim nickiem.</b></center><br>';
}
?>
