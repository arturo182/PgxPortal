<?
include "config.php";
if($_POST['submit'] != "") {
$query = mysql_query("SELECT uid FROM ". $db_prefix ."member");
while($member = mysql_fetch_array($query)) {
$status = "status$member[uid]";
$status = "${$status}";
$delete = "delete$member[uid]";
$delete = "${$delete}";
$username = "username$member[uid]";
$username = "${$username}";

if($delete != "") {
mysql_query("DELETE FROM ". $db_prefix ."member WHERE uid='$delete'");
}

mysql_query("UPDATE ". $db_prefix ."member SET status='$status' WHERE username='$username'");
}
$tresc = "Zmiany zapisano";
} else {
$tresc = "<table border='0' cellpadding='4' cellspacing='0' width='100%'>
  <tr>
    <td width='100%'><p align='justify'>Zezwolenia:<br>
    u¿ytkownik - mo¿e pisaæ i edytowaæ swoje posty, zak³adaæ nowe tematy<bR>
    moderator - mo¿e to co u¿ytkownik + edytowaæ, przesuwaæ, kasowaæ i blokowaæ tematy/posty<br>
    administrator - mo¿e to co u¿ytkownik i moderator + ma dostêp do panelu admina
    </td>
  </tr>
</table>
 <table border='0' cellpadding='4' cellspacing='0' width='100%'>
  <form method='post' action='admin.php#bottom'>
   <tr>
     <td class='header' width='100%'>Wyszukiwarka u¿ytkowników</td>
   </tr>
   <tr>
     <td class='row2' width='100%'>Wpisz czê¶æ lub ca³y login u¿ytkownika którego szukasz.</td>
   </tr>
   <tr>
     <td width='100%' align='center'><input type='text' name='searchname' size='30' style='width: 200px'></td>
   </tr>
   <tr>
     <td width='100%' align='center'><input type='hidden' name='mode' value='users'><input type='submit' name='searchsubmit' value=' Szukaj '></td>
   </tr>
  </form>
 </table><br>
<table width='100%' border='0' cellpadding='4' cellspacing='0' align='center'>
 <form method='post' action='admin.php?mode=users#bottom'>
  <tr>
   <td width='5%' align='center' height='20'><b>Kasuj</b></td>
   <td width='10%' height='20'><b>U¿ytkownik</b></td>
   <td width='10%' height='20'><b>Status</b></td>
   <td width='10%' height='20'><b>Rejestracja</b></td>
   <td width='5%' align='center' height='20'><b>Postów</b></td>
  </tr>";

	if($_POST['searchsubmit'] != "") {
            $ttnum = 1;
		$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username LIKE '%$searchname%'") or die(mysql_error());
		while($member = mysql_fetch_array($query)) {
			$member[regdate] = $datetime = date("Y-m-d H:i", $member[regdate]);

			if($member[status] == "U¿ytkownik") {
				$selected[0] = "selected=\"selected\" ";
			} elseif($member[status] == "Moderator") {
				$selected[1] = "selected=\"selected\" ";
			} elseif($member[status] == "Administrator") {
				$selected[2] = "selected=\"selected\" ";
			}

$tresc .= "<input type='hidden' name='username$member[uid]' value='$member[username]'>
 <tr>
  <td width='5%' align='center'><input type='checkbox' name='delete$member[uid]' value='$member[uid]' /></td>
  <td width='10%'>$member[username]</td>
  <td width='10%'><select name='status$member[uid]'>
     <option $selected[0]value='U¿ytkownik'>U¿ytkownik</option>
     <option $selected[1]value='Moderator'>Moderator</option>
     <option $selected[2]value='Administrator'>Administrator</option>
  </td>
  <td width='10%'>$member[regdate]</td>
  <td align='center' width='5%'>$member[posts]</td>
 </tr>";
                  $ttnum = altcolors($ttnum);
			$selected = "";
		}
	}
$tresc .= "</table><br><div align='center'><input type='submit' name='submit' value=' Zapisz '></form></div>";
}
TableAdmin("U¿ytkownicy",$tresc);
?>
