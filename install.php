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
if(filesize("config.php") >= "150")
{
header("Location: index.php");
exit;
}
echo "<html>
<head>
  <meta http-equiv='Content-Type' Content='text/html; charset=iso-8859-2'>
  <title>PgxPortal - Instalacja</title>
  <link rel='stylesheet' href='themes/default2/style.css' type='text/css'>
  <script type='text/javascript'>
    <!--
    function licence()
    {
    if(document.getElementById('license_box').checked == true )
    {
    document.getElementById('next_box').disabled=false;
    } else {
    document.getElementById('next_box').disabled=true;
    } }
    -->
  </script>
</head>
<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' background='themes/default2/gfx/bg.gif'>
  <center>
    <table width='704' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td valign='bottom' background='themes/default2/gfx/leftbg.gif' style='border-right: 1px solid #1c1c1c;' width='1'>
          &nbsp;
        </td>
        <td>
          <table cellspacing='0' cellpadding='0' width='700'>
            <tr>
              <td colspan='3' >
                <table border='0' cellpadding='0' cellspacing='0'>
                  <tr>
                  </tr>
                  <tr>
                    <td align='right' valign='center' background='themes/default2/gfx/top3.gif' width='704' height='120'>
                    </td>
                  </tr>
                  <tr>
                  </tr>
                </table>
                ";
                switch ($step) {
                default:
                echo "
                <table width='703' border='0' cellspacing='0' cellpadding='0'>
                  <tr>
                    <td height='21' align='left' background='themes/default2/gfx/titlebg.gif' style='padding-left: 6px;'>
                      <strong>Krok I - Licencja</strong>
                    </td>
                  </tr>
                  <tr>
                    <td background='themes/default2/gfx/installbg.gif' style='padding: 6px; text-align : justify;' >
                      Licencja skryptu <font class='yellow'>PgxPortal 1.5</font><br>
                      Autor: <font class='yellow'>arturo182</font><br>
                      E-mail: <a href='mailto:arturo182@pgxportal.pnth.net'>arturo182@pgxportal.pnth.net</a><br>
                      Strona WWW: <a href='http://www.pgxportal.glt.pl'>www.pgxportal.glt.pl</a><br><br>
                      Modified by <font class='yellow'> <a href='mailto:globus_1989@o2.pl'>GLOBUS</a></font><br><br>
                      <b><font class='yellow'>Licencja skryptu:</font></b><br>
                      Starałem się zrobić wszystko co możliwe, aby system działał poprawnie, jednak nie ponoszę odpowiedzialności za ewentualne szkody powstałe w wyniku jego działania i/lub nieprawidłowego użycia.<br><br>
                      Nie podporządkowanie się do poniższych warunków licencji jest łamaniem przepisów o prawie autorskim, a jego nieprzestrzeganie będzie karane.<br><br>
                      <b><font class='yellow'>Zabrania się rozpowszechniania skryptu pobierając za to jakiekolwiek opłaty!</font></b><br><br>
                      Dla celów niekomercyjnych system jest darmowy, trzeba jedynie spełnić warunki:<br>
                      <ul>
                        <li>*Pozostawić reklamę tekstową u dołu każdej strony, która jest linkiem do oficjalnej strony skryptu.</li>
                        <li>Dopuszczalne jest wprowadzanie do kodu poprawek czy nawet znacznych zmian jednak nie upoważnia to do usunięcia wymaganego napisu.</li>
                      </ul>
                      <br>
                      SKRYPT CHRONIONY PRZEZ BOWI Group<br>
                      Biuro Ochrony Witryn Internetowych<br>
                      www.bowi.org.pl<br>
                      biuro@bowi.org.pl<br>
                      <br><br>
                      Skrypt stanowi wlasność intelektualną jego autora  i jest chroniony przede wszystkim przez <font class='yellow'>Prawo Autorskie.</font><br>
                      Wszelkie zmiany w kodzie źródłowym skryptu, przypisywanie sobie autorstwa, a w szczególności poprzez zmiane oznaczeń graficznych, tekstowych, nazwy skryptu, przyczyni się do wystąpienia na drogę prawna celem uzyskania zadośćuczynienia, na wniosek poszkodowanego, który zostanie powiadomiony przez BOWI o wykryciu  <font class='yellow'>nielegalnej kopii skryptu</font> i który upoważnił BOWI do takowego dzialania.<br>
                      Niniejszy skrypt znajduje sie w Archiwum BOWI celem porówniania kodu zrodłowego i wszelkich oznaczeń stwierdzajacych faktycznego autora oraz stanowiąc materiał dowodowy w przypadku kradzieży praw autorskich.<br>
                      <br>*) jednolinijkowy napis, wysokość czcionki 10px u dołu strony, treść: 'powered by PgxPortal'. Zamiast 'powered' można użyć słowa 'engine'.<br><br>
                      <center>
                        <b><font class='yellow'>Przeczytałem i akceptuje warunki licencji.</font></b> <input type='checkbox' id='license_box' onclick='licence()' /><br>
                        <form action='install.php' method='post'>
                          <input type='hidden' name='step' value='1'>
                          <input type='submit' name='submit' value='Dalej >>' id='next_box' disabled='disabled' />
                        </form>
                      </center>
                    </td>
                  </tr>
                  <tr>
                  </tr>
                </table>";
                break;
                case "1";
  echo "<table width='703' border='0' cellspacing='0' cellpadding='0'>
                  <tr>
                    <td height='21' align='left' background='themes/default2/gfx/titlebg.gif' style='padding-left: 6px;'>
                      <strong>Krok II - Sprawdzanie uprawnień</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style='padding: 6px; text-align : justify;'>
                      <table width='400'>
                          <tr>
                            <td border='1px solid black;' colspan='2' background='themes\default2\gfx\bg2.gif' align='center'>
                              <b>Pliki:</b>
                            </td>
                          </tr>";



$files = array('config.php');
            $countFiles = count( $files );
            $trueFiles = 0;
            $falseFiles = 0;

            foreach( $files as $file ) {
              if( file_exists( $prefix.$file ) )  {
                if( $fp = @fopen( $prefix.$file, 'a' ) ) {
                  fclose( $fp );
                  print('<tr><td width="60%">'.$file.'</td><td width="40%" align="left"><font color="green">Ok</font></td></tr>');
                }
                else  {
                  $bad_file="1";
                  print('<tr><td width="60%">'.$file.'</td><td width="40%" align="left"><font color="red">BŁĄD</font></td></tr>');
                }
              }
              else  {
                                $bad_file="1";
                  print('<tr><td width="60%">'.$file.'</td><td width="40%" align="left"><font color="red">BŁĄD</font></td></tr>');
              }
            }
            unset( $files );
            unset( $file );

if($bad_file != "1")
{
echo '<tr><td width="100%" align="center"><form action="install.php"><input type="hidden" name="step" value="2"><input type="submit" value="Krok III"></form></td></tr>';
}
else
{
echo '<tr><td width="100%" align="center"><b>Nadaj pliku <u>config.php</u> atrybut <u>0777</u></b></td></tr>';
}

echo "                        </table>
                      </td>
                    </tr>
                  </form>
                </table>
              </td>
            </tr>
          </table>";

                break;
                case "2":
                $adres  = 'http://'.$_SERVER[HTTP_HOST].$SCRIPT_NAME;
                $adress = array();
                $adress = explode("/",$adres);
                $adress = array_reverse($adress);
                $adress = $adress[0];
                
                $how_cut = strlen($adress);
                $how_cut = $how_cut+1;
                
                $adress = substr($adres, 0, -$how_cut);
                
                echo "
                <table width='703' border='0' cellspacing='0' cellpadding='0'>
                  <tr>
                    <td height='21' align='left' background='themes/default2/gfx/titlebg.gif' style='padding-left: 6px;'>
                      <strong>Krok III - Konfiguracja</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style='padding: 6px; text-align : justify;' align='center'>
                      <table width='700'>
                        <form action='install.php' method='post'>
                          <tr>
                            <td border='1px solid black;' colspan='2' background='themes\default2\gfx\bg2.gif' align='center'>
                              <b>Baza danych</b>
                            </td>
                          </tr>
                          <tr>
                            <td width='40%'>Host</td>
                            <td width='60%'><input type='text' name='db_host' value='localhost' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Nazwa Bazy</td>
                            <td width='60%'><input type='text' name='db_name' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Użytkownik</td>
                            <td width='60%'><input type='text' name='db_user' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Hasło</td>
                            <td width='60%'><input type='text' name='db_pass' size='30'>
                            </td>
                          <tr>
                            <td width='40%'>Prefix</td>
                            <td width='60%'><input type='text' name='prefix' size='30' value='pgx_'></td>
                          </tr>
                          </tr>
                          <tr>
                            <td border='1px solid black;' colspan='2' background='themes\default2\gfx\bg2.gif' align='center'>
                              <b>Strona</b>
                            </td>
                          </tr>
                          <tr>
                            <td width='40%'>Nazwa</td>
                            <td width='60%'><input type='text' name='site_name' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Adres</td>
                            <td width='60%'><input type='text' name='site_adress' value='". $adress ."' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Limit newsów na stronie głównej</td>
                            <td width='60%'><input type='text' name='site_nlimit' size='30'>
                            </td>
                          </tr>
                          <tr>
                            <td width='40%'>Limit tematów na 1 stronie forum</td>
                            <td width='60%'><input type='text' name='site_maxtop' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Limit odpowiedzi na 1 stronie tematu</td>
                            <td width='60%'><input type='text' name='site_maxrep' size='30'></td>
                          </tr>
                          <tr>
                            <td border='1px solid black;' colspan='2' background='themes\default2\gfx\bg2.gif' align='center'>
                              <b>Właściciel</b>
                            </td>
                          </tr>
                          <tr>
                            <td width='40%'>Nick</td>
                            <td width='60%'><input type='text' name='own_nick' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Hasło</td>
                            <td width='60%'><input type='text' name='own_pass' size='30'></td>
                          </tr>
                          <tr>
                            <td width='40%'>Em@il</td>
                            <td width='60%'><input type='text' name='own_email' size='30'></td>
                          </tr>
                          <tr>
                            <td border='1px solid black;' colspan='2' background='themes\default2\gfx\bg2.gif' align='center'><input type='hidden' name='step' value='3'><input type='submit' value='Instaluj'></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </form>
                </table>
              </td>
            </tr>
          </table>
          ";
          break;
          case "3":
          echo "
          <table width='703' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td height='21' align='left' background='themes/default2/gfx/titlebg.gif' style='padding-left: 6px;'>
                <strong>Krok IV - Instalacja</strong>
              </td>
            </tr>
            <tr>
              <td background='themes/default2/gfx/installbg.gif' style='padding: 6px; text-align : justify;' >
                <center>
                  <b><font class='yellow'>Instalowanie... </font></b><br><br>";
                  echo "Łączenie się z bazą danych: ";
                  if(MYSQL_CONNECT($db_host,$db_user,$db_pass)) {
                  echo "<font color='green'>OK</font><br>";
                  } else {
                  echo "<font color='red'>BŁĄD!</font><br>";
                  $blad = "1";
                  }
                  echo "Wybieranie bazy <b>$db_name</b>: ";
                  if(@mysql_select_db($db_name)) {
                  echo "<font color='green'>OK</font><br>";
                  } else {
                  echo "<font color='red'>BŁĄD!</font><br>";
                  $blad = "1";
                  }
                  echo "Tworzenie baz danych: ";
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."stats (counter varchar(50) NOT NULL default '0',msie varchar(50) NOT NULL default '0',opera varchar(50) NOT NULL default '0',mozilla varchar(50) NOT NULL default '0',other varchar(50) NOT NULL default '0',win98 varchar(50) NOT NULL default '0',winxp varchar(50) NOT NULL default '0',linux varchar(50) NOT NULL default '0',osther varchar(50) NOT NULL default '0') TYPE=MyISAM;");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."bans (id smallint(5) unsigned NOT NULL auto_increment,ip varchar(100) NOT NULL default '',UNIQUE KEY id (id)) TYPE=MyISAM;");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."articles (id int(5) unsigned NOT NULL auto_increment,  title varchar(255) NOT NULL default '',  text text NOT NULL,  date text NOT NULL,  folder varchar(255) NOT NULL default '0',  UNIQUE KEY id (id)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."menu (`id` int(5) unsigned NOT NULL auto_increment,  `title` varchar(255) NOT NULL default '',  `text` text NOT NULL,  `side` varchar(10) NOT NULL default '',  `order` varchar(255) NOT NULL default '0',  UNIQUE KEY `id` (`id`)) TYPE=MyISAM AUTO_INCREMENT=20 ;");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."articles_folders (id int(255) NOT NULL auto_increment,  name varchar(255) NOT NULL default '',  description text NOT NULL,  UNIQUE KEY id (id)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."banners (`id` smallint(5) unsigned NOT NULL auto_increment, `code` text NOT NULL, `views` varchar(255) NOT NULL default '0', `clicks` varchar(255) NOT NULL default '0', `link` varchar(255) NOT NULL default '', `image` varchar(255) NOT NULL default '', `type` varchar(255) NOT NULL default '', `width` varchar(255) NOT NULL default '', `height` varchar(255) NOT NULL default '', `max_views` varchar(255) NOT NULL default '', `enable` char(1) NOT NULL default '1', PRIMARY KEY  (`id`)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=3");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."config (owner varchar(255) NOT NULL default '',  sitename varchar(255) NOT NULL default '',  theme varchar(255) NOT NULL default '',  nlimit varchar(3) NOT NULL default '',  siteadress varchar(255) NOT NULL default '',  maxtop varchar(3) NOT NULL default '',  maxrep varchar(3) NOT NULL default '',  adminemail varchar(255) NOT NULL default '', `avatar_width` varchar(3) NOT NULL default '', `avatar_height` varchar(3) NOT NULL default '', `guests_download_files` varchar(1) NOT NULL default '', `stats` varchar(1) NOT NULL default '', comments varchar(1) NOT NULL default '', pool varchar(1) NOT NULL default '') TYPE=MyISAM");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."files (id int(255) NOT NULL auto_increment,  folderid int(255) NOT NULL default '0',  filesize varchar(255) NOT NULL default '',  filename varchar(255) NOT NULL default '',  description text NOT NULL,  downloads int(255) NOT NULL default '0',  url text NOT NULL,  UNIQUE KEY id (id)) TYPE=MyISAM AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."files_broken (id int(5) unsigned NOT NULL auto_increment,  fileid varchar(255) NOT NULL default '',  date varchar(255) NOT NULL default '',  UNIQUE KEY id (id)) TYPE=MyISAM AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."files_folders (id int(255) NOT NULL auto_increment,  name varchar(255) NOT NULL default '',  description text NOT NULL,  UNIQUE KEY id (id)) TYPE=MyISAM AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."files_rank (fid varchar(255) NOT NULL default '0',  rank varchar(255) NOT NULL default '0',  votes varchar(255) NOT NULL default '') TYPE=MyISAM;");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."forum (fid int(10) NOT NULL auto_increment,  name varchar(50) NOT NULL default '',  description text,  dorder smallint(6) NOT NULL default '0',  posts int(20) NOT NULL default '0',  lastpost int(20) NOT NULL default '0',  postlast varchar(255) NOT NULL default '',  lastpostauthor varchar(255) NOT NULL default '',  PRIMARY KEY  (fid),  KEY fid (fid)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."guest_book (id smallint(5) unsigned NOT NULL auto_increment,  author varchar(255) NOT NULL default '',  email varchar(255) NOT NULL default '',  text text NOT NULL,  date varchar(255) NOT NULL default '',  UNIQUE KEY id (id)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."member (uid int(10) NOT NULL auto_increment,  username varchar(30) NOT NULL default '',  password varchar(20) NOT NULL default '',  status varchar(20) NOT NULL default '',  email varchar(40) default NULL,  website varchar(40) default NULL,  aim varchar(40) default NULL,  msn varchar(40) default NULL,  location varchar(40) default NULL,  sig text,  regdate int(20) NOT NULL default '0',  posts int(10) NOT NULL default '0',  yahoo varchar(255) NOT NULL default 'image/no_avatar.gif',  PRIMARY KEY  (uid)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=2");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."topic (tid int(10) NOT NULL auto_increment,  fid smallint(6) NOT NULL default '0',  name varchar(50) NOT NULL default '',  replies int(20) NOT NULL default '0',  views int(20) NOT NULL default '0',  lastpost int(20) NOT NULL default '0',  topped char(3) NOT NULL default '',  author varchar(20) NOT NULL default '',  status varchar(255) NOT NULL default '',  PRIMARY KEY  (tid),  KEY tid (tid),  KEY fid (fid)) TYPE=MyISAM PACK_KEYS=0");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."words (id int(11) NOT NULL auto_increment,  word text NOT NULL,  replacement text NOT NULL,  PRIMARY KEY  (id)) TYPE=MyISAM PACK_KEYS=0");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."news (id int(5) unsigned NOT NULL auto_increment,  title varchar(255) NOT NULL default '',  text text NOT NULL,  date varchar(255) NOT NULL default '',  author varchar(255) NOT NULL default '',  UNIQUE KEY id (id)) TYPE=MyISAM PACK_KEYS=0");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."news_comments (  newsid smallint(5) NOT NULL default '0',  author varchar(255) NOT NULL default '',  text text NOT NULL,  date varchar(255) NOT NULL default '',  id smallint(5) NOT NULL auto_increment,  PRIMARY KEY  (id),  UNIQUE KEY id (id)) TYPE=MyISAM PACK_KEYS=0");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."online (ip varchar(30) NOT NULL default '',  time int(20) NOT NULL default '0',  name varchar(255) NOT NULL default '',  site varchar(255) NOT NULL default '') TYPE=MyISAM");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."page (id int(5) unsigned NOT NULL auto_increment,  title varchar(255) NOT NULL default '', text text NOT NULL, nl2br varchar(5) NOT NULL default '',  UNIQUE KEY id (id)) TYPE=MyISAM");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."poll (id int(20) NOT NULL auto_increment,  content text,  number int(30) default '0',  title varchar(255) NOT NULL default '0',  PRIMARY KEY  (id)) TYPE=MyISAM");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."poll_title (id int(5) NOT NULL auto_increment,title text,active varchar(5) NOT NULL default 'yes',PRIMARY KEY  (id)) TYPE=MyISAM;");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."post (pid int(10) NOT NULL auto_increment,  tid smallint(6) NOT NULL default '0',  subject varchar(50) NOT NULL default '',  message text NOT NULL,  author varchar(30) NOT NULL default '',  dateline int(20) NOT NULL default '0',  PRIMARY KEY  (pid),  KEY tid (tid)) TYPE=MyISAM PACK_KEYS=0");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."privmsg (id int(5) NOT NULL auto_increment,  receiver varchar(30) NOT NULL default '',  message text NOT NULL,  sender varchar(30) NOT NULL default '',  topic varchar(150) NOT NULL default '',  time int(14) NOT NULL default '0',  PRIMARY KEY  (id)) TYPE=MyISAM PACK_KEYS=0");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."shoutbox (id int(255) unsigned NOT NULL auto_increment,  author varchar(255) NOT NULL default '',  text text NOT NULL,  date varchar(255) NOT NULL default '',  PRIMARY KEY  (id)) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1");
                  $bazy .= mysql_query("CREATE TABLE ". $prefix ."smiley (sid int(10) NOT NULL auto_increment,  url varchar(30) NOT NULL default '',  code varchar(30) NOT NULL default '',  PRIMARY KEY  (sid)) TYPE=MyISAM AUTO_INCREMENT=16");
                  if($bazy) {
                  echo "<font color='green'>OK</font><br>";
                  } else {
                  echo "<font color='red'>BŁĄD!</font><br>";
                  $blad = "1";
                  }
                  echo "Wypełnianie baz danych: ";
                  function encrypt($string) {
                  $crypted = crypt(md5($string), md5($string));
                  return $crypted;
                  }
                  $pass = encrypt($_POST[own_pass]);
                  $time = time();
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."stats VALUES ('0', '0', '0', '0', '0', '0', '0', '0', '0');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."config (owner, sitename, theme, nlimit, siteadress, maxtop, maxrep, adminemail, avatar_width, avatar_height, guests_download_files, stats, comments, pool) VALUES ('$_POST[own_nick]', '$_POST[site_name]', 'default2', '$_POST[site_nlimit]', '$_POST[site_adress]', '$_POST[site_maxtop]', '$_POST[site_maxrep]', '$_POST[own_email]', '150','150','0','0','0','0');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."member (uid, username, password, status, email, website, aim, msn, location, sig, regdate, posts, yahoo) VALUES(1, '$_POST[own_nick]', '$pass', 'Administrator', '$_POST[own_email]', '', '', '', '', '', '$time', 0, '');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (1,'Menu Główne','<font class=\"p\">&raquo;</font> <a href=\"index.php\">Strona główna</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"archive.php\">Archiwum newsów</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"articles.php\">Artykuły</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"download.php\">Download</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"banners.php?action=show\">Bannery</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"guestbook.php\">Księga Gości</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"forumi.php\">Forum</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"search.php\">Wyszukiwarka</a>\r\n<font class=\"p\">&raquo;</font> <a href=\"stats.php\">Statystyki</a>','left','1')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (2,'Menu użytkownika','||user||','right','1')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (3,'Top 5 ściąganych','||topd||','left','2')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (4,'Ankieta','||poll||','right','2')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (5,'Online','||online||','left','3')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (6,'Kalendarz','||calendar||','right','3')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (7,'Zmiana themesa','||themes||','left','4')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (8,'Shoutbox','||shout||','right','4')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (9,'Statystyki','||stats||','left','5')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."menu VALUES (10,'Ostatnio na Forum','||newpost||','left','6')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."news (id, title, text, date, author) VALUES (1, 'Przykładowy news', 'To już 4 wersja mojego skryptu, może czas zmienić przykładowego newsa.\r\nA więc ten news będzie połączony z ogłoszeniem, a raczej prośbą.\r\nPopularność Pgx''a jest dość mała i nikt nie chce dla niego tworzyć modułów, themesów, bloków itp., ale moze stworzenie kilku dodatków mogłoby mu pomóc, dlatego apeluję do wszystkich znających PHP - twórzcie dodatki, pomórzcie Pgx''owi przeżyć!\r\nWszelkie oferty i uwagi przyjmę na arturo182@pgxportal.pnth.net\r\n\r\nZ góry dziękuje za każdą pomoc i za wybranie mojego skryptu, Arturo.\r\n', $time, '1')");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (1, 'biggrin.gif', ':D');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (2, 'blink.gif', ':blink:');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (3, 'cool.gif', '8)');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (4, 'dry.gif', '-.-');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (5, 'happy.gif', '^_^');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (6, 'huh.gif', ':huh:');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (7, 'laugh.gif', ':lol:');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (8, 'mad.gif', ':angry:');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (9, 'mellow.gif', ':|');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (10, 'ohmy.gif', ':O');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (11, 'sad.gif', ':(');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (12, 'smile.gif', ':)');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (13, 'tongue.gif', ':P');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (14, 'unsure.gif', ':unsure:');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."smiley (sid, url, code) VALUES (15, 'wink.gif', ';)');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."poll_title VALUES (1,'Jak Ci się podoba nowy PGXPORTAL Modified by GLOBUS?','on');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."poll VALUES (1,'jest super!','0','1');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."poll VALUES (2,'dobry','0','1');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."poll VALUES (3,'przejdzie','0','1');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."poll VALUES (4,'marnie','0','1');");
                  $inserty .= mysql_query("INSERT INTO ". $prefix ."poll VALUES (5,'żałośnie','0','1');");
                  if(strstr($inserty, "0")) {
                  echo "<font color='red'>BŁĄD!</font><br>";
                  $blad = "1";
                  } else {
                  echo "<font color='green'>OK</font><br>";
                  }
                  if($blad)
                  {
                  echo "<b>Wystąpił błąd, sprawdź przy którym kroku instalacji i postaraj się go naprawić, a potem uruchom instalacje ponownie.</b>";
                  }
                  else
                  {
                  echo "<br>Generowanie pliku config.php: ";
                  if($file = fopen("config.php", "w")) {
                  fputs($file, "<?");
                  fputs($file, "\n");
                  fputs($file, "//\n");
                  fputs($file, "//Plik wygenerowany przez instalator, nic tutaj nie zmieniaj!\n");
                  fputs($file, "//\n");
                  fputs($file, "\n");
                  fputs($file, "\$hostname = \"$_POST[db_host]\";");
                  fputs($file, "\n");
                  fputs($file, "\$dbName = \"$_POST[db_name]\";");
                  fputs($file, "\n");
                  fputs($file, "\$username = \"$_POST[db_user]\";");
                  fputs($file, "\n");
                  fputs($file, "\$passwrd = \"$_POST[db_pass]\";");
                  fputs($file, "\n");
                  fputs($file, "\$db_prefix = \"$_POST[prefix]\";");
                  fputs($file, "\nMYSQL_CONNECT(\$hostname,\$username,\$passwrd) OR DIE(\"Nie mozna sie polaczyc z baza danych.\");\n@mysql_select_db(\$dbName) or die(\"Nie można wybrac bazy.\");\n?>");
                  fclose($file);
                  echo "<font color='green'>OK</font><br>";
                  echo "<b>PgxPortal został poprawnie zainstalowany, ciesz się nowym CMS'em ;) <a href='index.php'>Strona Główna</a>";
                  }
                  else
                  {
                  echo "<font color='red'>BŁĄD!</font><br>";
                  $blad = "1";
                  }
                  }
                  echo "
                </td>
              </tr>
              <tr>
              </tr>
            </table>
            ";
            break;
            }
            echo "
          </td>
        </tr>
        <tr>
          <td colspan='3'>
            <table width='100%' height='16' border='0' cellpadding='0' cellspacing='0'>
              <tr>
                <td background='themes/default2/gfx/footerbg.gif' align='center'>
                  copyright &copy; 2005 by <a href='mailto:arturo182@pgxportal.pnth.net'>arturo182</a>
                </td>
              </tr>
            </table>
          </table>
          </td>
          <td background='themes/default2/gfx/rightbg.gif' width='1' style='border-left: 1px solid #1c1c1c;'>&nbsp;</td>
        </tr>
      </table>
      <table width='704'>
        <tr>
          <Td align='right'><a href='http://www.pgxportal.glt.pl/'>powered by PgxPortal</a>
          </td>
        </tr>
      </table>
    </center>
  </body>
  </html>";
?>
