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
$site = "Strony informacyjne";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
openSite("Strona informacyjna");
MenuLeft();

if (isset($id))
{
$query = mysql_query("SELECT * FROM ". $db_prefix ."page WHERE id='$id'");

$article=mysql_fetch_array($query);

if($article[id] == "")
{
$title = "B³±d";
$tresc = "Strona informacyjna o takim ID nie istnieje!";
}
else
{
if($userstatus == "Administrator")
{
$title .= '<a href="admin.php?mode=pages&action=delete&id'.$id.'#bottom">[U]</a> <a href="admin.php?mode=pages&action=edit&id='.$id.'#bottom">[E]</a> ';
}

if($article['nl2br'] == "on")
{
$tresc = nl2br($article['text']);
}
else
{
$tresc = $article['text'];
}
$title .= $article['title'];
}
}
else
{
$title = "B³±d";
$tresc = "Strona informacyjna o takim ID nie istnieje!";
}

openTable($title,$tresc);

MenuRight();
closeTable();
closeSite();

?>
