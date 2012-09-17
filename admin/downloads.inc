<?
include "config.php";
function nothing() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."files_folders");
$how_files = mysql_num_rows($query);
if($how_files == "0")
{
$tresc .= "Brak folderów do edycji.";
}
else
{
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='30%'>Nazwa</td><td width='50%' >Opis</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
$tresc .= "<tr><td>" . $row['id'] . "</td><td><a href='admin.php?mode=downloads&action=folder&id=" . $row['id'] . "#bottom'>" .  $row['name'] . "</a></td><td>" . $row['description'] . "</td><td align='center'><a href='admin.php?mode=downloads&action=edit&id=" . $row['id'] . "#bottom'>E</a></td><td align='center'><a href='admin.php?mode=downloads&action=delete&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .="</table>";
}
TableAdmin("Download - Foldery","$tresc");
}

function folder() {
global $id,$db_prefix;

$query = mysql_query("SELECT * FROM ". $db_prefix ."files WHERE folderid='$id'");
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='40%'>Nazwa</td><td width='10%'>Rozmiar</td><td width='35%' >Opis</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
$tresc .= "<tr><td>" . $row['filename'] . "</td><td>" .  $row['filesize'] . "</td><td>" . $row['description'] . "</td><td align='center'><a href='admin.php?mode=downloads&action=editf&id=" . $row['id'] . "#bottom'>E</a></td><td align='center'><a href='admin.php?mode=downloads&action=deletef&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
}
$query = mysql_query("SELECT * FROM ". $db_prefix ."files_folders where id='$id'");
while($row = mysql_fetch_array($query))
 {
 $name = $row['name'];
 }
$tresc .="</table>";

TableAdmin("Download -> $name","$tresc");
}

function edit() {
global $id,$db_prefix;

$query = mysql_query("SELECT * FROM ". $db_prefix ."files_folders where id='$id'");


while($article=mysql_fetch_array($query)){
$name = $article['name'];
$description = $article['description'];
}
$tresc = "<table cellspacing='3'><FORM METHOD='POST' ACTION='admin.php?mode=downloads&action=edits#bottom'><tr><td>Nazwa foldera: </td><td><input type='text' name='f_name' size='25' value='$name'></td></tr><tr><td>Opis foldera: </td><td><TEXTAREA NAME='f_description' ROWS='4' COLS='35'>$description</TEXTAREA></td></tr><tr><td><input type='hidden' name='f_id' value='$id'><INPUT TYPE='submit' VALUE='Zapisz'></td></tr></table></FORM>";

TableAdmin("Folder plików","$tresc");
}


function edits() {
global $f_name,$f_description,$f_id,$db_prefix;
mysql_query("UPDATE ". $db_prefix ."files_folders SET `name` = '$f_name',`description` = '$f_description' WHERE `id` = '$f_id'");
$tresc = "Folder plików zapisano.";

TableAdmin("Folder plików","$tresc");
}

function listfiles() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."files");
$how_files = mysql_num_rows($query);
if($how_files == "0")
{
$tresc = "Brak plików";
}
else
{
$tresc = "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='30%'>Nazwa</td><td width='50%' >Opis</td><td width='10%' align='center'>Edytuj</td><td width='10%' align='center'>Usuñ</td></tr>";

while($row = mysql_fetch_array($query))
 {
$tresc .= "<tr><td>" . $row['id'] . "</td><td><a href='download.php?func=fileinfo&id=" . $row['id'] . "#bottom'>" .  $row['filename'] . "</a></td><td>" . $row['description'] . "</td><td align='center'><a href='admin.php?mode=downloads&action=editf&id=" . $row['id'] . "#bottom'>E</a></td><td align='center'><a href='admin.php?mode=downloads&action=deletef&id=" . $row['id'] . "#bottom'>U</a></td></tr>";
}
$tresc .="</table>";
}
TableAdmin("Download - Pliki","$tresc");
}


function delete() {
global $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."files_folders WHERE `id` = '$id'");
mysql_query("DELETE FROM ". $db_prefix ."files WHERE `folderid` = '$id'");
$tresc = "Folder i pliki w nim zawarte usuniêto.";

TableAdmin("Folder plików","$tresc");
}

function editf() {
global $id,$db_prefix;

$query = mysql_query("SELECT * FROM ". $db_prefix ."files where id='$id'");
while($article=mysql_fetch_array($query)){
$filename = $article['filename'];
$folderid = $article['folderid'];
$url = $article['url'];
$description = $article['description'];
$filesize  = $article['filesize'];
}
$tresc .= "<table cellspacing='3'><FORM METHOD='POST' ACTION='admin.php?mode=downloads&action=editsf#bottom'><tr><td>Nazwa pliku: </td><td><input type='text' name='name' size='25' value='$filename'></td></tr><tr><td>Adres pliku: </td><td><input type='text' name='url' size='25' value='$url'></td></tr><tr><td>Romiar pliku: </td><td><input type='text' name='filesize' size='25' value='$filesize '></td></tr><tr><td>Folder: </td><td><select name='folderid' style='width: 140px;'>";
$sql = "SELECT * FROM ". $db_prefix ."files_folders";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$folder_id = $row['id'];
$folder_name = $row['name'];
if($folder_id == $folderid) {
$sel = "selected";
}
$tresc .= "<option value='$folder_id' $sel>$folder_name</option>";
}
$tresc .= "</select></td></tr><tr><td>Opis pliku: </td><td><TEXTAREA NAME='description' ROWS='4' COLS='35'>$description</TEXTAREA></td></tr><tr><td><input type='hidden' name='id' value='$id'><INPUT TYPE='submit' VALUE='Zapisz'></td></tr></table></FORM>";

TableAdmin("Plik","$tresc");
}

function editsf() {
global $folderid,$url,$name,$description,$filesize,$id,$db_prefix;

mysql_query("UPDATE ". $db_prefix ."files SET `folderid` = '$folderid',`filesize` = '$filesize',`filename` = '$name',`description` = '$description',`url` = '$url' WHERE `id` = '$id'");
$tresc = "Plik zapisano.";

TableAdmin("Plik","$tresc");
}

function deletef() {
global  $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."files WHERE `id` = '$id'");
$tresc = "Plik usuniêto.";

TableAdmin("Download","$tresc");
}

function add() {
$tresc .= "<table cellspacing='3'><FORM METHOD='POST' ACTION='admin.php?mode=downloads&action=adds#bottom'><tr><td>Nazwa foldera: </td><td><input type='text' name='name' size='25'></td></tr><tr><td>Opis foldera: </td><td><TEXTAREA NAME='description' ROWS='4' COLS='35'></TEXTAREA></td></tr><tr><td><INPUT TYPE='submit' VALUE='Dodaj'></td></tr></table></FORM>";

TableAdmin("Dodaj folder plików","$tresc");
}

function adds() {
global $name,$description,$db_prefix;

mysql_query("INSERT INTO ". $db_prefix ."files_folders (name,description) VALUES ('$name','$description')");
$tresc = "Folder dodano.";

TableAdmin("Dodaj folder plików","$tresc");
}

function broken() {
global $db_prefix;
$query = mysql_query("SELECT * FROM ". $db_prefix ."files_broken ORDER BY date DESC");
$how_bad_links = mysql_num_rows($query);
if($how_bad_links == "0")
{
$tresc .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='100%'>Brak zg³oszeñ o b³êdnych plikach</td></tr></table>";
}
else
{
$tresc .= "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td width='5%'>ID</td><td width='40%'>Plik</td><td width='20%' align='center'>Data</td><td width='10%' align='center'>Usuñ</td><td width='10%' align='center'>Usuñ plik</td><td width='10%' align='center'>Edytuj plik</td></tr>";

while($article=mysql_fetch_array($query)){
$queryf = mysql_query("SELECT * FROM ". $db_prefix ."files WHERE id=$article[fileid]");
while($file=mysql_fetch_array($queryf)){
$tresc .= "<tr><td>" . $article['id'] . "</td><td>" . $file['filename'] . "</a></td><td>" . $article['date'] . "</td><td  align='center'><a href='admin.php?mode=downloads&action=deleteb&id=" . $article['id'] . "#bottom'>U</a><td align='center'><a href='admin.php?mode=downloads&action=deletef&id=" . $article['fileid'] . "#bottom'>U</a></td><td align='center'><a href='admin.php?mode=downloads&action=editf&id=" . $article['fileid'] . "#bottom'>E</a></td></tr>";
}
}
$tresc .= "<tr><td colspan='6'>&nbsp;</td></tr>";
$tresc .= "<tr><td colspan='6' align='right'><a href='admin.php?mode=downloads&action=deleteball#bottom'>Usuñ wszystkie powiadomienia o b³êdnych plikach</a></td></tr>";
$tresc .="</table>";
}
TableAdmin("Zg³oszenia zepsutych plików","$tresc");
}

function deleteb(){
global $id,$db_prefix;

mysql_query("DELETE FROM ". $db_prefix ."files_broken WHERE `id` = '$id'");
$tresc = "Powiadomienie usuniêto.";

TableAdmin("Zepsuty plik","$tresc");
}

function deleteball(){
global $db_prefix;
mysql_query("DELETE FROM ". $db_prefix ."files_broken");
$tresc = "Powiadomienia usuniêto.";

TableAdmin("Zepsuty plik","$tresc");
}

function addsf() {
global $name,$url,$size,$folderid,$description,$db_prefix;

mysql_query("INSERT INTO ". $db_prefix ."files (folderid,url,description,filename,filesize) VALUES ('$folderid','$url','$description','$name','$size')");
$tresc = "Plik dodano.";

TableAdmin("Dodaj plik","$tresc");
}

function addf() {
global $db_prefix,$send_file;
$result = mysql_query("SELECT * FROM ". $db_prefix ."files_folders");
$how_folders = mysql_num_rows($result);

if(!$show)
{
$show = "1";
}

if($how_folders == "0")
 {
  $tresc .= "Utwó¿ kategoriê";
 }
else
{


if($send_file == "file")
{
  $file = $_FILES['file']['tmp_name'];
  $name_file = $_FILES['file']['name'];
  if(file_exists("upload/files/$name_file"))
  {
  $tresc = "Plik o nazwie <b>$name_file</b> Istnieje";
  }
  else
  {
   copy($file, "upload/files/$name_file");

                $f_n = array();
                $f_n = explode(".",$name_file);
                $f_n = array_reverse($f_n);
                $f_n = $f_n[0];

                $how_cut = strlen($f_n);
                $how_cut = $how_cut+1;

                $f_n = substr($name_file, 0, -$how_cut);

                $filesize = filesize("upload/files/$name_file");
                $filesize = $filesize.' bajtów';
                
                $adress = 'upload/files/'.$name_file;
                
                
        }
}

if($show == "1")
{
$tresc .= "<table cellspacing='3'><FORM METHOD='POST' ACTION='admin.php?mode=downloads&action=addsf#bottom'><tr><td>Nazwa pliku: </td><td><input type='text' name='name' size='25' value='$f_n'></td></tr><tr><td>Adres pliku: </td><td><input type='text' name='url' size='25' value='$adress'></td></tr><tr><td>Romiar pliku: </td><td><input type='text' name='size' size='25' value='$filesize'></td></tr><tr><td>Folder: </td><td><select name='folderid' style='width: 140px;'>";
while($row = mysql_fetch_array($result))
{
$folder_id = $row['id'];
$folder_name = $row['name'];
$tresc .= "<option value='$folder_id'>$folder_name</option>";
}
$tresc .= "</select></td></tr><tr><td>Opis pliku: </td><td><TEXTAREA NAME='description' ROWS='4' COLS='35'></TEXTAREA></td></tr><tr><td><INPUT TYPE='submit' VALUE='Dodaj'></td></tr></table></FORM>";
}

}
TableAdmin("Dodaj plik","$tresc");
}



function upload()
{
$tresc ='
<form method="post" action="admin.php?mode=downloads&action=addf#bottom" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="0" width="100%" align="center">
 <tr>
  <td width="100%" class="row1" align="center"><input type="file" name="file"><input type="hidden" name="send_file" value="file"></td>
 </tr>
 <tr>
  <td width="100%" class="row1" align="center"><input type="submit" value="Upload Pliku"></td>
 </tr>
</table>
</form>';

TableAdmin("Dodaj plik","$tresc");
}
?>
