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
$site = "Wyszukiwarka";
include "include.php";
include "config.php";
include "themes/$theme/theme.php";
openSite("Wyszukiwarka");
MenuLeft();
if($_GET['author'] == "") {
if($_POST['words'] == "") {
$title = "Wyszukiwanie";
$tresc = '
<center>
  <table cellspacing="3">
    <form action="search.php" method="post">
      <tr>
        <td>szukane s�owo:</td>
        <td><input type="text" name="words"></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="Szukaj"></td>
      </tr>
    </table>
  </center>
  ';
  } else {
  $title = 'Wyniki wyszukiwania s�owa <u>'. stripslashes($words) .'</u>';
  $tresc = '
  <center>
    <table cellspacing="3">
      <form action="search.php" method="post">
        <tr>
          <td>szukane s�owo:</td>
          <td><input type="text" name="words"></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="submit" value="Szukaj">
          </td>
        </tr>
      </table>
    </center>
    ';
    $tresc .= '<hr><font class="yellow">Wyniki wyszukiwania w artyku�ach:</font><br>';
    $query = mysql_query("SELECT * FROM ". $db_prefix ."articles WHERE text LIKE '%$words%'");
    if(mysql_num_rows($query) == "0") {
    $tresc .= "Nie znaleziono pasuj�cych artyku��w.<br><br>";
    } else {
    while($article=mysql_fetch_array($query)){
    $tresc .= '<font class="p">&raquo;</font> <a href="articles.php?id=' . $article[id] . '">"' . $article[title] . '"</a><br>';
    }
    $tresc .= "<br>";
    }
    $tresc .= "<hr><font class='yellow'>Wyniki wyszukiwania w newsach:</font><br>";
    $query = mysql_query("SELECT * FROM ". $db_prefix ."news WHERE text LIKE '%$words%'");
    if(mysql_num_rows($query) == "0") {
    $tresc .= "Nie znaleziono pasuj�cych news�w.<br><br>";
    } else {
    while($article=mysql_fetch_array($query)){
    $tresc .= '<font class="p">&raquo;</font> <a href="gallery.php?func=imageinfo&id=' . $article[id] . '">"' . $article[title] . '"</a><br>';
    }
    $tresc .= "<br>";
    }
    $tresc .= "<hr><font class='yellow'>Wyniki wyszukiwania w forum:</font><br>";
    $query = mysql_query("SELECT * FROM ". $db_prefix ."topic WHERE name LIKE '%$words%'");
    if(mysql_num_rows($query) == "0") {
    $tresc .= "Nie znaleziono pasuj�cych temat�w.<br><br>";
    } else {
    while($article=mysql_fetch_array($query)){
    $tresc .= '<font class="p">&raquo;</font> <a href="topic.php?tid=' . $article[tid] . '">"' . $article[name] . '"</a><br>';
    }
    $tresc .= "<br>";
    }
    }
    } else {
    
    $user_search_topics = mysql_fetch_array(mysql_query("SELECT * FROM ". $db_prefix ."member WHERE uid = '$author'"));
    
    $title = "Wyszukiwanie - posty $user_search_topics[username]";
    $tresc .= "<font class='yellow'>Wyniki wyszukiwania:</font><br>";
    $query = mysql_query("SELECT * FROM ". $db_prefix ."post WHERE author LIKE '$user_search_topics[username]'");
    if(mysql_num_rows($query) == "0") {
    $tresc .= "Nie znaleziono pasuj�cych post�w.<br><br>";
    } else {
    while($article=mysql_fetch_array($query)){
    $tresc .= '<font class="p">&raquo;</font> <b><a href="topic.php?tid=' . $article[tid] . '#' . $article[pid] . '">' . $article[subject] . '</a></b><br>';
    }
    }
    }
    openTable($title,$tresc);
    MenuRight();
    closeTable();
    closeSite();
?>
