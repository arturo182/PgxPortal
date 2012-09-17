<?php
$border = "#1c1c1c"; //border wokół newsów i artykułów
$bgcom = "#1c1c1c"; //tło formularza komentarza newsa
$sname = $theme;
function page_header($nav, $themsg, $title,$addt) {
global $sitename,$userstatus,$pgxuser,$pgxpass,$sname;
echo "<a id='top'></a>
<html>
<head>
  <meta http-equiv='Content-Type' Content='text/html; charset=ISO-8859-2'>
  <script language='javascript1.2' src='nb.js' type=text/javascript>
  </script>
  <title>$sitename - Forum</title>
  <link rel='stylesheet' href='themes/$sname/style.css' type='text/css'>
</head>
<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' background='themes/$sname/gfx/bg.gif'>
  <center>
    <table width='704' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td valign='bottom' background='themes/$sname/gfx/leftbg.gif' style='border-right: 1px solid #1c1c1c;' width='1'>
          &nbsp;</td>
          <td>
            <table cellspacing='0' cellpadding='0' width='700'>
              <tr>
                <td colspan='3'>
                  <table width='703' border='0' cellpadding='0' cellspacing='0'>
                    <tr>
                      <td align='right' colspan='2' valign='center' background='themes/$sname/gfx/top3.gif' width='704' height='184' style='padding-right: 3px; padding-bottom: 20px;'>
                        ";
                        include "banners.php";
                        echo "
                      </td>
                    </tr>
                    <tr>
                      <td background='themes/$sname/gfx/top2.gif' width='60%' height='31'>
                        &nbsp;<a href='index.php'>Index</a> - <a href='member.php'>Użytkownicy</a> - <a href='forumi.php'>Forum</a> $nav";if($userstatus == "Administrator")  echo ' - <a href="admin.php#menu">Panel admina</a><br>'; echo "</td>
                        <td background='themes/$sname/gfx/top2.gif' width='40%' height='31' align='right'>
                          <form action='search.php' method='post'>
                            szukaj: <input type='text' name='words'>&nbsp;</td>
                          </tr>
                        </form>
                      </table>
                      <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                        <tr>
                          <td>
                            $addt";
                            }
                            function page_footer() {
                            global $owner,$adminemail,$sname;
                            echo "<table width='100%' height='16' border='0' cellpadding='0' cellspacing='0'>
                              <tr>
                                <td background='themes/$sname/gfx/footerbg.gif' align='center'>copyright &copy; 2005 by <a href='mailto:$adminemail'>$owner</a></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign='bottom' background='themes/$sname/gfx/rightbg.gif' width='1' style='border-left: 1px solid #1c1c1c;'>
                        &nbsp;</td>
                      </tr>
                      <tr>
                        <td align='left' valign='top'>forum powered by <a href='http://www.myphp.ws' target='_blank'>MyPHP Forum</a></td>
                          <td align='right'><a target='_blank' href='http://www.pgxportal.glt.pl/'>POWERED BY PGXPORTAL v.1.4</a><br><div class='small'>MODIFED by GLOBUS v.1.0</div></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </center>
              </body>
              </html>
              ";
              }
              function forum_footer($multi,$addt) {
              echo "
            </table>
            <bR>
            <table width='100%'>
              <tr>
                <td>
                  $addt</td>
                  <td align='right'>
                    $multi</td>
                  </tr>
                </table>
                ";
                }
                function topic_footer($multi, $tid, $mod,$addt) {
                echo "
                <table border='0' cellpadding='3' cellspacing='0'  width='100%'>
                  <tr>
                    <td width='30%'>
                      $addt&nbsp;&nbsp;$mod</td>
                      <td align='right' width='60%'>
                        $multi</td>
                      </tr>
                    </table>
                    <br>";
                    }
                    function post_form($pgxuser, $pgxpass, $tid, $fid, $premsg, $autosmiley, $presubject, $pid, $topicn, $action, $deletehtml,$subin) {
                    global $sname;
                    echo "
                    <form method='post' action='post.php?action=$action' name='input'>
                      <table border='0' cellpadding='3' cellspacing='1' width='100%'>
                        <tr>
                          <td colspan='2' background='themes/$sname/gfx/titlebg.gif'>
                            <b>Napisz odpowiedź/nowy temat</b></td>
                          </tr>
                          <tr>
                            <td width='22%' background='themes/$sname/gfx/bg1.gif'>
                              <b>Temat</b></td>
                              <td background='themes/$sname/gfx/bg2.gif'>
                                <input type='text' name='subject' style='width: 307px' value='$presubject' $subin>";
                                if($subin) {
                                echo "<input type='hidden' name='subject' value='$presubject'>";
                                }
                                echo "
                              </td>
                            </tr>
                            <tr>
                              <td valign='top' background='themes/$sname/gfx/bg1.gif'>
                                <table width='100%' border='0' cellspacing='0' cellpadding='1'>
                                  <tr>
                                    <td >
                                      <b>Treść wiadomości</b></td>
                                    </tr>
                                    <tr>
                                      <td valign='middle' align='center'>
                                        <br />
                                        <table width='100' border='0' cellspacing='0' cellpadding='5'>
                                          <tr align='center'>
                                            <td><b>Emotki</b></td></tr>
                                            <tr>
                                              <td>
                                                <table cellpadding='4'>$autosmiley</table>
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                  <td valign='top' background='themes/$sname/gfx/bg2.gif'>
                                    <table border='0' cellspacing='0' cellpadding='2'>
                                      <tr align='center' valign='middle'>
                                        <td>
                                          <input type=\"button\" value=\"b\" style=\"font-weight:bold;\" OnClick=\"javascript:AddText('[b] [/b]')\" onMouseover=\"show_text(0,'div1')\" onMouseout=\"resetit('div1')\"></td>
                                          <td>
                                            <input type=\"button\" value=\"i\" style=\"font-style:italic;\" OnClick=\"javascript:AddText('[i] [/i]')\" onMouseover=\"show_text(1,'div1')\" onMouseout=\"resetit('div1')\"></td>
                                            <td>
                                              <input type=\"button\" value=\"u\" style=\"font-decoration:underline;\" OnClick=\"javascript:AddText('[u] [/u]')\" onMouseover=\"show_text(2,'div1')\" onMouseout=\"resetit('div1')\"></td>
                                              <td>
                                                <input type=\"button\" value=\"img\" OnClick=\"javascript:AddText('[img]http:// [/img]')\" onMouseover=\"show_text(5,'div1')\" onMouseout=\"resetit('div1')\"></td>
                                                <td>
                                                  <input type=\"button\" value=\"quote\" OnClick=\"javascript:AddText('[quote] [/quote]')\" onMouseover=\"show_text(7,'div1')\" onMouseout=\"resetit('div1')\"></td>
                                                  <td>
                                                    <input type=\"button\" value=\"code\" OnClick=\"javascript:AddText('[code] [/code]')\" onMouseover=\"show_text(6,'div1')\" onMouseout=\"resetit('div1')\"></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan='9'>
                                                      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                        <tr>
                                                          <td>
                                                            &nbsp;Kolor: <select onchange='showcolor(this.options[this.selectedIndex].value)' name='txtcolor' onMouseover=\"show_text(8,'div1')\" onMouseout=\"resetit('div1')\">
                                                            <option style='background-color: #000000; color: #000000' value=#000000>#000000</option>
                                                            <option style='background-color: #ff0000; color: #ff0000' value=#ff0000>#ff0000</option>
                                                            <option style='background-color: #990000; color: #990000' value=#990000>#990000</option>
                                                            <option style='background-color: #006600; color: #006600' value=#006600>#006600</option>
                                                            <option style='background-color: #00ff00; color: #00ff00' value=#00ff00>#00ff00</option>
                                                            <option style='background-color: #0000ff; color: #0000ff' value=#0000ff>#0000ff</option>
                                                            <option style='background-color: #000099; color: #000099' value=#000099>#000099</option>
                                                            <option style='background-color: #ffff00; color: #ffff00' value=#ffff00>#ffff00</option>
                                                            <option style='background-color: #ff6600; color: #ff6600' value=#ff6600>#ff6600</option>
                                                            <option style='background-color: #00ffff; color: #00ffff' value=#00ffff>#00ffff</option>
                                                            <option style='background-color: #ff00ff; color: #ff00ff' value=#ff00ff>#ff00ff</option>
                                                            <option style='background-color: #ff99ff; color: #ff99ff' value=#ff99ff>#ff99ff</option>
                                                            <option style='background-color: #9900ff; color: #9900ff' value=#9900ff>#9900ff</option>
                                                            <option style='background-color: #999999; color: #999999' value=#999999>#999999</option>
                                                            <option style='background-color: #c0c0c0; color: #c0c0c0' value=#c0c0c0>#c0c0c0</option>
                                                            <option value=#ffffff selected>Wybierz</option>
                                                            </select>&nbsp;Rozmiar:<select name='addbbcode20' onChange='javascript:AddText('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + '] [/size]')' onMouseover=\"show_text(9,'div1')\" onMouseout=\"resetit('div1')\">
                                                            <option value='6'>Minimalny</option>
                                                            <option value='8'>Mały</option>
                                                            <option value='10' selected>Normalny</option>
                                                            <option value='14'>Duży</option>
                                                            <option  value='20'>Ogromny</option>
                                                            </select>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan='9'>
                                                      <table border='0' cellpadding='4' cellspacing='0' width='100%' align='center'>
                                                        <tr>
                                                          <td height='24' align='center' background='themes/$sname/gfx/bg1.gif'>
                                                            &nbsp;
                                                            <span id='div1'>
                                                            </span>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan='9'>
                                                      <textarea cols='50' rows='10' name='message' style='width: 307px'>$premsg</textarea></td>
                                                    </tr>
                                                  </table>
                                                </td>
                                              </tr>
                                              ";
                                              if($deletehtml) {
                                              echo "
                                              <tr>
                                                <td valign='top' background='themes/$sname/gfx/bg1.gif'>
                                                </td>
                                                <td background='themes/$sname/gfx/bg2.gif'>
                                                  $deletehtml</td>
                                                </tr>
                                                ";
                                                }
                                                echo "
                                                <tr>
                                                  <td colspan='2' align='center' background='themes/$sname/gfx/bg1.gif'>
                                                    <input type='hidden' name='pgxuser' value='$pgxuser'><input type='hidden' name='pgxpass' value='$pgxpass'><input type='hidden' name='tid' value='$tid'><input type='hidden' name='fid' value='$fid'><input type='hidden' name='pid' value='$pid'><input type='submit' name='submit' value=' Wyśli '></td>
                                                  </tr>
                                                </table>
                                                ";
                                                }
?>
