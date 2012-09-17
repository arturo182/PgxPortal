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

if ($func == "vote")
{
setcookie("pgxvote",$id);
}

$site = "Download";
include "include.php";
include "config.php";
$guests = $guests_download_files;

if ($func == "download")
 {
  if ($id)
   {
    if (!$pgxuser && $guests =="0")
    {
    include "themes/$theme/theme.php";
    openSite("Pliki");
    MenuLeft();
    
    $title .= "B£¡D!";
    $tresc .= '<center><b>Tylko <a href="member.php?action=reg">zarejestrowani</a> i <a href="loginout.php?action=login">zalogowani</a> u¿ytkownicy mog± ¶ciagac pliki.</b></center>';

    openTable($title,$tresc);
    MenuRight();
    closeTable();
    closeSite();
   }
   else
   {
    $sql = "SELECT * FROM ". $db_prefix ."files WHERE id = $id";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $link = $row['url'];

  $nazwa_pliku = array();
  $nazwa_pliku = explode("/",$link);
  $nazwa_pliku = array_reverse($nazwa_pliku);

  $nazwa_pliku = $nazwa_pliku[0];


if(@fopen($link, "r"))
{
    $newsql = "UPDATE ". $db_prefix ."files SET downloads=downloads+1 WHERE id = '$id'";
    mysql_query($newsql);
    
   header("Content-type: application/octet-stream");
   header("Content-Disposition: attachment; filename=$nazwa_pliku");
   readfile($link);
exit;
}
else
{
$date = date("Y-m-d H:i");
mysql_query("INSERT INTO ". $db_prefix ."files_broken ( `fileid` , `date`) VALUES ('$id', '$date')");
echo "B³¹d 404 pliku <b>$nazwa_pliku</b> nie znaleziono na serverze";
exit;
}
   }
 }
 else
 {
 include "themes/$theme/theme.php";
 openSite("Pliki");
 MenuLeft();
 
  $title .= "B£¡D!";
  $tresc .= "Nie ma pliku o podanym ID!";

  openTable($title,$tresc);
  MenuRight();
  closeTable();
  closeSite();
 }
}

include "themes/$theme/theme.php";
openSite("Pliki");
MenuLeft();
if (!$func)
{
$sql = "SELECT * FROM ". $db_prefix ."files_folders";
$result = mysql_query($sql);
$title .= "Download - dostêpne foldery";
if(mysql_num_rows($result) == "0") {
$tresc .= "Brak folderów";
} else {
while($row = mysql_fetch_array($result))
	 {
	  $sql2 = mysql_query("SELECT * FROM ". $db_prefix ."files WHERE folderid=" . $row['id'] . "");
	  $files = mysql_num_rows($sql2);
if($userstatus == "Administrator") {
$tresc .= '<a href="admin.php?mode=downloads&action=delete&id=' . $row[id] . '#bottom">[U]</a> <a href="admin.php?mode=downloads&action=edit&id=' . $row['id'] . '#bottom">[E]</a> ';
}
$tresc .= '<font class="p">&raquo;</font> <a href="download.php?func=selectfolder&id=' . $row[id] . '">' .  $row[name] . '</a> ['.$files.']<br>' . $row[description] . '<BR><br>';
}
}
}
if ($func == "fileinfo")
{
if (!$id)
{
$title .= "B£¡D";
	   $tresc .= "B³êdne ID!";
	} else {
	$sql = "SELECT * FROM ". $db_prefix ."files WHERE id = $id";
	$result = mysql_query($sql);
$query = mysql_query("SELECT * FROM ". $db_prefix ."files_rank where fid='$id'");
$check = mysql_num_rows($query);
if($check != "0" && $stats = mysql_fetch_array($query))
{
$ranks = $stats['rank'];
$votes = $stats['votes'];
$rank =  round($ranks/$votes,2);
} else {
$rank = "0";
$votes ="0";
}

	       if ($row = mysql_fetch_array($result))
	       {
	       
	       
  $filetype = array();
  $filetype = explode(".",$row[url]);
  $filetype = array_reverse($filetype);
  $filetype = $filetype[0];

$title .= 'Download -> '.  $row[filename];
$tresc .= '
<table width="100%">
  <tr>
    <td>
      <table width="100%" >
        <tr>
          <td><b>Nazwa:</b></td>
          <td>' .  $row[filename] . '</td>
        </tr>
        <tr>
          <td><b>Rozmiar: </b></td>
          <td>' . $row[filesize] . '</td>
        </tr>
        <tr>
          <td><b>Rozszerzenie: </b></td>
          <td>' . $filetype . '</td>
        </tr>
        <tr>
          <td><b>Pobrañ: </b></td>
          <td>' .  $row[downloads] . '</td>
        </tr>
        <tr>
          <td><b>Link nie dzia³a?</b></td>
          <td><a href="download.php?func=broken&id=' . $row[id] . '"><font color="red">Zg³o¶ to</font></td>
        </tr>
        <tr>
          <td><b>Ocena: </b></td>
          <td>'.$rank.' ('.$votes.' g³osów)</td>
        </tr>
        <td><b>Oceñ plik: </b></td>
        <td>
          <form><input type="hidden" value="vote" name="func"><select name="rank" onchange="this.form.submit()"><option value="-" selected>-</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select><input type="hidden" name="id" value="' . $row[id] . '"></form>
        </td>
      </tr>
      <tr>
        <td colspan="2"><b>Opis:</b> <BR>' .  $row[description] . '</td>
      </tr>
    </table>
  </td>
  <td><a href="download.php?func=download&id=' . $row[id] . '"><center><img src="themes/'.$theme.'/gfx/download.gif" border="0"><br>¦ci±gaj plik</a></td>
  </tr>
</table>
';
		} else {
$title .= "B£¡D!";
		$tresc .= "B³êdne ID";
		}
}
}
if ($func == "broken")
{
if (!$id)
{
$title .= "B£¡D";
$tresc .= "B³êdne ID!";
} else {
$cheack_file_row = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."files WHERE id = '$id'"));
if(@fopen($cheack_file_row['url'], "r"))
{
$title .= "Zg³o¶ nie dzia³aj±cy plik";
$tresc .= 'Link jest prawid³owy! <i>(zosta³ w³a¶nie sprawdzony przez system)</i><br>Powiadomienie <b>NIE</b> zosta³o wys³ane! <br><a href="download.php">Wróæ</a>';
}
else
{
$date = date("Y-m-d H:i");
mysql_query("INSERT INTO ". $db_prefix ."files_broken ( `fileid` , `date`) VALUES ('$id', '$date')");
$title .= "Zg³o¶ nie dzia³aj±cy plik";
$tresc .= 'Powiadomienie zosta³o wys³ane!<br><a href="download.php">Wróæ</a>';
}
}
}
if ($func == "selectfolder")
{
if(isset($_GET['order']) && isset($_GET['esc'])) {
$what1 = $_GET['order'];
$what2 = $_GET['esc'];
} else {
$what1 = "id";
$what2 = "desc";
}
	$sql = "SELECT * FROM ". $db_prefix ."files_folders WHERE id = $id";
	$result = mysql_query($sql);
	$sql2 = "SELECT * FROM files WHERE folderid = $id ORDER BY $what1 $what2";
	$result2 = mysql_query($sql2);
	if ($row = mysql_fetch_array($result))
	 {
	  $title .= "Download -> " . $row['name'] . "";
				$sql = "SELECT * FROM ". $db_prefix ."files WHERE folderid = $id ORDER BY $what1 $what2";
				$result = mysql_query($sql);
				if (mysql_num_rows($result) == "0") {
	                        $tresc .= "W tym folderze nie ma ¿adnych plików!";
	                        } else {
$tresc .= '
<center>
  sortuj wed³ug: tytu³u <a href="download.php?func=selectfolder&id='.$id.'&order=filename&esc=asc"><img src="themes/'.$theme.'/gfx/up.gif" border="0"></a> <a href="download.php?func=selectfolder&id='.$id.'&order=filename&esc=desc"><img src="themes/'.$theme.'/gfx/down.gif" border="0"></a> | daty <a href="download.php?func=selectfolder&id='.$id.'&order=filesize&esc=asc"><img src="themes/'.$theme.'/gfx/up.gif" border="0"></a> <a href="download.php?func=selectfolder&id='.$id.'&order=filesize&esc=desc"><img src="themes/'.$theme.'/gfx/down.gif" border="0"></a>
</center>
<br>';
				while ($row2 = mysql_fetch_array($result)) {
if($userstatus == "Administrator") {
$tresc .= '<a href="admin.php?mode=downloads&action=deletef&id=' . $row2[id] . '#bottom">[U]</a> <a href="admin.php?mode=downloads&action=editf&id=' . $row2[id] . '#bottom">[E]</a> ';
}
$tresc .= '<font class="p">&raquo;</font> <a href="download.php?func=fileinfo&id=' .  $row2[id] . '">' . $row2[filename] . '</a><br>' .  $row2[description] . '<br><br>';
				}
				}
}
}
if ($func == "vote")
{
$query = mysql_query("SELECT * FROM ". $db_prefix ."files_rank WHERE fid='$id'");
$num = mysql_num_rows($query);
if($num == "0")
{
mysql_query("INSERT INTO ". $db_prefix ."files_rank ( `fid` , `rank` , `votes` )VALUES ('$id', '$rank', '1')");
}
else
{
if($_COOKIE[pgxvote] != $id)
{
mysql_query("UPDATE ". $db_prefix ."files_rank SET rank=rank+$rank,votes=votes+1 WHERE `fid` = '$id'");
}
}
$title = "Ocena pliku.";
$tresc = 'Dziêkujemy za ocenê pliku.<br><a href="download.php?func=fileinfo&id='.$id.'">Wróæ</a>';
}
openTable($title,$tresc);
MenuRight();
closeTable();
closeSite();
?>
