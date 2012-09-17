<?
include "config.php";
if(!$save) {
$tresc = "<table width='100%' border='0' cellpadding='4' cellspacing='0' align='center'>
<form method='post' action='admin.php?mode=forum#bottom'>
<tr>
<td class='header' width='10%' align='center' height='20'><b>Skasuj</b></td>
<td class='header' width='35%' height='20'><b>Nazwa forum</b></td>
<td class='header' width='45%' height='20'><b>Opis</b></td>
<td class='header' width='10%' align='center' height='20'><b>Kolejno¶æ</b></td>
</tr>";
$query = mysql_query("SELECT * FROM ". $db_prefix ."forum ORDER BY dorder");
while($forum = mysql_fetch_array($query)) {

$tresc .= "<tr>
<td valign='top' align='center' height='50'><input type='checkbox' name='delete$forum[fid]' value='$forum[fid]'></td>
<td valign='top' height='50'><input type='text' name='name$forum[fid]' value='$forum[name]' size='30'></td>
<td valign='top' height='50'><textarea cols='45' rows='3' name='description$forum[fid]'>$forum[description]</textarea></td>
<td valign='top' height='50' align='center'><input type='text' name='dorder$forum[fid]' value='$forum[dorder]' size='2'></td>
</tr>";

}
$tresc .= "</table>
<br>
<table width='100%' border='0' cellpadding='4' cellspacing='0' align='center'>
<tr>
<td width='10%' align='center' height='20'>&nbsp;</td>
<td width='35%' height='20'><b>Dodaj nowe forum:</b></td>
<td  width='45%' height='20'>&nbsp;</td>
<td  width='10%' height='20'>&nbsp;</td>
</tr>
<tr>
<td valign='top' align='center'>&nbsp;</td>
<td valign='top'><input type='text' name='newname' size='30'></td>
<td valign='top'><textarea cols='45' rows='3' name='newdescription'></textarea></td>
<td valign='top' align='center'><input type='text' name='newdorder' size='2'></td>
</tr>
</table>
<table width='100%' border='0' cellpadding='4' cellspacing='0' align='center'>
<tr>
<td width='100%' align='center'><input type='hidden' name='save' value='save'><input type='submit' name='submit' value=' Wy¶li '></td>
</tr>
</form>
</table>";

TableAdmin("Forum",$tresc);
} else {

	$query = mysql_query("SELECT * FROM ". $db_prefix ."forum") or die(mysql_error());
	while($forum = mysql_fetch_array($query)) {
		$name = "name$forum[fid]";
		$name = "${$name}";
		$description = "description$forum[fid]";
		$description = "${$description}";
		$dorder = "dorder$forum[fid]";
		$dorder = "${$dorder}";
		$delete = "delete$forum[fid]";
		$delete = "${$delete}";

		if($delete != "") {
			mysql_query("DELETE FROM ". $db_prefix ."forum WHERE fid='$delete'");
			mysql_query("DELETE FROM ". $db_prefix ."topic WHERE fid='$delete'");
		}
		mysql_query("UPDATE ". $db_prefix ."forum SET name='$name', description='$description', dorder='$dorder' WHERE fid='$forum[fid]'") or die(mysql_error());
	}

	if($newname != "") {
		mysql_query("INSERT INTO ". $db_prefix ."forum VALUES ('', '$newname', '$newdescription', '$newdorder', '', '', '', '')") or die(mysql_error());
	}
$tresc .= "Forum uaktualniono.";

TableAdmin("Forum",$tresc);
}
?>

