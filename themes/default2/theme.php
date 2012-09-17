<?
$border = "#1c1c1c"; //border wokół newsów i artykułów
$bgcom = "#6b6b6c"; //tło formularza komentarza newsa
$sname = $theme;
$query = mysql_query("SELECT * FROM ". $db_prefix ."member WHERE username='$pgxuser'");
$member = mysql_fetch_array($query);
if($pgxuser != "" && $pgxpass != "") {
$userstatus = $member['status'];
}
function openSite($title) {
global $sitename,$userstatus,$pgxuser,$pgxpass,$sname;
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" Content="text/html; charset=ISO-8859-2">
  <title>'.$sitename.' - '.$title.'</title>
  <link rel="stylesheet" href="themes/'.$sname.'/style.css" type="text/css">
  
<script language="javascript" type="text/javascript">
function update_smiley(newimage)
{
	document.smiley_image.src = "image/smiles/" + newimage;
}
</script>
  
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="themes/'.$sname.'/gfx/bg.gif">
  <center>
    <table width="704" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="bottom" background="themes/'.$sname.'/gfx/leftbg.gif" style="border-right: 1px solid #1c1c1c;" width="1">
          &nbsp;
        </td>
        <td>
          <table cellspacing="0" cellpadding="0" width="704" >
            <tr>
              <td colspan="3" >
                <table width="704" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2" valign="center" background="themes/'.$sname.'/gfx/top3.gif" width="704" height="184" style="padding-right: 3px; padding-bottom: 20px;">
                      ';
                      include "banners.php";
                      echo '
                    </td>
                  </tr>
                  <tr>
                    <td background="themes/'.$sname.'/gfx/top2.gif" width="60%" height="31">
                      &nbsp;<a href="index.php">Index</a> - <a href="articles.php">Artykuły</a> - <a href="download.php">Download</a> - <a href="forumi.php">Forum</a>';if($userstatus == "Administrator")  echo ' - <a href="admin.php#menu">Panel admina</a><br>';
echo '                    </td>
                    <td background="themes/'.$sname.'/gfx/top2.gif" width="40%" height="31" align="right">
                      <form action="search.php" method="post">
                        szukaj: <input type="text" name="words">&nbsp;
                      </td>
                    </tr>
                  </form>
                </table>
                ';
                }
                function openLeftMenu() {
                global $sname;
                echo '
              </td>
            </tr>
            <tr>
              <td valign="top"  background="themes/'.$sname.'/gfx/lmenubg.gif">
                ';
                }
                function closeLeftMenu() {
                echo '
              </td>
              <td valign="top" width="553">
                ';
                }
                function openRightMenu() {
                global $sname;
                echo '
              </td>
              <td valign="top" background="themes/'.$sname.'/gfx/rmenubg.gif">
                ';
                }
                function openTable($title,$tresc) {
                global $sname;
                echo '
                <table width="404" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="21" align="left" background="themes/'.$sname.'/gfx/titlebg.gif" style="padding-left: 6px;">
                      <strong>'.$title.'</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 6px; text-align : justify;" >
                      '.$tresc.'
                    </td>
                  </tr>
                  <tr>
                  </tr>
                  <tr>
                    <td valign="top">
                      <img src="themes/'.$sname.'/gfx/separ.gif" width="3" height="6">
                    </td>
                  </tr>
                </table>
                ';
                }
                function openTableMini($title,$tresc) {
                global $sname;
                echo '
                <table width="553" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="21" align="left" background="themes/'.$sname.'/gfx/titlebg.gif" style="padding-left: 6px;">
                      <strong>'.$title.'</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 6px; text-align : justify;" >
                      '.$tresc.'
                    </td>
                  </tr>
                  <tr>
                  </tr>
                  <tr>
                    <td valign="top">
                      <img src="themes/'.$sname.'/gfx/separ.gif" width="3" height="6">
                    </td>
                  </tr>
                </table>
                ';
                }
                function LeftMenu($title,$text,$id) {
                global $sitename,$userstatus,$pgxuser,$pgxpass,$sname;
                echo '
                <table width="150" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="170" height="21" background="themes/'.$sname.'/gfx/lbutton.gif">
                      ';
                      if($userstatus == "Administrator") {
                      echo '<a href="admin.php?mode=menus&action=delete&id=' . $id . '#bottom">[U]</a> <a href="admin.php?mode=menus&action=edit&id=' . $id . '#bottom">[E]</a>';
                      }
                      echo '<strong>&nbsp;'.$title.'</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 6px;">
                      '.$text.'
                    </td>
                  </form>
                </td>
              </tr>
            </table>
            ';
            }
            function LeftMenuSpecial($title,$spec,$id) {
            global $sitename,$userstatus,$pgxuser,$pgxpass,$sname;
            echo '
            <table width="150" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="21" background="themes/'.$sname.'/gfx/lbutton.gif">
                  ';
                  if($userstatus == "Administrator") {
                  echo '<a href="admin.php?mode=menus&action=delete&id=' . $id . '#bottom">[U]</a> <a href="admin.php?mode=menus&action=edit&id=' . $id . '#bottom">[E]</a>';
                  }
                  echo '<strong>&nbsp;'.$title.'</strong>
                </td>
              </tr>
              <tr>
                <td class="block" style="padding: 6px;">
                  ';
                  include "blocks/$spec.inc";
                  echo '
                </td>
              </form>
            </td>
          </tr>
        </table>
        ';
        }
        function RightMenu($title,$text,$id) {
        global $sitename,$userstatus,$pgxuser,$pgxpass,$sname;
        echo '
        <table width="150" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="21" background="themes/'.$sname.'/gfx/rbutton.gif" align="right">
              <strong>'.$title.'&nbsp;';
              if($userstatus == "Administrator") {
              echo '<a href="admin.php?mode=menus&action=delete&id=' . $id . '#bottom">[U]</a> <a href="admin.php?mode=menus&action=edit&id=' . $id . '#bottom">[E]</a>';
              }
              echo '</strong>
            </td>
          </tr>
          <tr>
            <td style="padding: 6px;">
              '.$text.'
            </td>
          </tr>
        </table>
        ';
        }
        function RightMenuSpecial($title,$spec,$id) {
        global $sitename,$userstatus,$pgxuser,$pgxpass,$sname;
        echo '
        <table width="150" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="21" background="themes/'.$sname.'/gfx/rbutton.gif" align="right">
              <strong>'.$title.'&nbsp;</strong>';
              if($userstatus == "Administrator") {
              echo '<a href="admin.php?mode=menus&action=delete&id=' . $id . '#bottom">[U]</a> <a href="admin.php?mode=menus&action=edit&id=' . $id . '#bottom">[E]</a> ';
              }
              echo '
            </td>
          </tr>
          <tr>
            <td style="padding: 6px;">
              ';
              include "blocks/$spec.inc";
              echo '
            </td>
          </tr>
        </table>
        ';
        }
        function closeTable() {
        echo '
      </td>
    </tr>
    <tr>
      <td colspan="3">
        ';
        }
        function closeTableMini() {
        echo '
      </td>
      <tr>
        <td colspan="3">
          ';
          }
          function closeSite() {
          global $owner,$adminemail,$sname;
          echo '
          <table width="100%" height="16" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td background="themes/'.$sname.'/gfx/footerbg.gif" align="center">
                copyright &copy; 2005 by <a href="mailto:'.$adminemail.'">'.$owner.'</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td>
  <td valign="bottom" background="themes/'.$sname.'/gfx/rightbg.gif" width="1" style="border-left: 1px solid #1c1c1c;">
    &nbsp;
  </td>
</tr>
<tr>
  <td colspan="2" align="right"><a target="_blank" href="http://www.pgxportal.glt.pl/">POWERED BY PGXPORTAL v.1.4</a><br><div class="small">MODIFED by GLOBUS v.1.0</div></td>
</tr>
</table>
</center>
</body>
</html>';
}
if(isset($_GET['stheme'])) {
stheme($_GET['stheme']);
}
?>

