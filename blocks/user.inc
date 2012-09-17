<?
include "config.php";
if(!$_COOKIE[pgxuser] && !$_COOKIE[pgxpass]) {
echo '<form method="post" action="loginout.php?action=login">
<table border="0" cellpadding="3" cellspacing="0" width="100%" align="center">
 <tr>
  <td width="45%" height="20">Login:</td>
 </tr>
 <tr>
  <td width="55%" height="20"><input type="text" name="username" size="20"></td>
 </tr>
 <tr>
  <td width="45%" height="20">Has³o:</td>
 </tr>
 <tr>
  <td width="55%" height="20"><input type="password" name="password" size="20"></td>
 </tr>
 <tr>
  <td width="55%" colspan="2" align="center"><input type="submit" name="submit" value=" Wy¶li "></td>
 </tr>
</table>
</form>
<table border="0" cellpadding="3" cellspacing="0" width="100%" align="center">
 <tr>
   <td width="100%" class="sign" align="center"><a href="member.php?action=reg">Nie mam konta.</a><br><a href="forgot.php">Zapomnia³em has³a.</a></td>
 </tr>
</table>';
}
else {
$query = mysql_query("SELECT * FROM ". $db_prefix ."privmsg WHERE receiver='$pgxuser' ORDER BY id DESC");
$numrows = mysql_num_rows($query);
echo 'Witaj <b>'.$pgxuser.'</b>!<br>
<a href="privmsg.php">Wiadomo¶ci [<b>'.$numrows.'</B>]</a><br>
<a href="member.php?action=editpro">Profil</a><br>';
if($userstatus == "Administrator")
{
echo '<a href="admin.php#menu">Panel admina</a><br>';
}
echo '<a href="member.php">U¿ytkownicy</a><br>';         
echo '<a href="loginout.php?action=logout">Wyloguj</a>';
}

?>
