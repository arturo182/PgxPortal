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

$site = "Panel Admina";
require "include.php";
include "config.php";
include "themes/$theme/theme.php";
if($userstatus != "Administrator") {
openSite("Panel admina");
openTableMini("Panel Admina","
<center>
  <b>Dostêp tutaj, maj± tylko admini! Je¶li jeste¶ adminem, zaloguj siê.</b>
</center>
");
redirectit("loginout.php?action=login");
closeTableMini();
closeSite();
exit;
}
openSite("Panel admina");
function TableAdmin($title,$text) {
global $sname;
echo '
<table width="704" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="21" align="left" background="themes/'.$sname.'/gfx/titlebg.gif" style="padding-left: 6px;">
      <strong>'.$title.'</strong>
    </td>
  </tr>
  <tr>
    <td style="padding: 6px; text-align : justify;" >
      '.$text.'
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
$menu .= '<table width="100%" border="0" align="center">';
$menu .= "\r\n";


$dir = opendir("admin/");
while($r = readdir($dir))
 {
  $x = explode(".",$r);
  if($x[2] == "txt")
   {
    $module = $x[0];
    if(file_exists("admin/$module.inc"))
     {
      $count_modules++;
      $muduletitle[$count_modules]="$module";
     }
   }
}

$cols = "3";
$modules = $count_modules;
$rows = ceil($modules/$cols);

$total_width = "100";

$cols_widht = floor($total_width/$cols);

echo "
<script>
  function zmien(nazwa) {
  var d = document.getElementById(nazwa);
  if(d.style.display == 'block') {
  d.style.display = 'none';
  } else {
  d.style.display = 'block';
  }
  }
</script>";
$menu .= "<table border=\"0\" width=\"$total_width%\" align=\"center\">\r\n";

for($r=0;$r<$rows;$r++)
 {
  $menu .= " <tr>\r\n";

   for($c=0;$c<$cols;$c++)
    {

     $cp++;
     $modulename = $muduletitle[$cp];
      if(file_exists("admin/$modulename.inc"))
      {
     $file = file("admin/$modulename.inc.txt");
     $split = explode("|",$file[0]);
     $image = $split[0];
     $title = $split[1];
     


     $menu .= '  <td align="center" valign="top" width="'. $cols_widht .'%"><a href="#menu" OnClick="zmien(\''. $modulename .'\')"><img src="'. $image .'" border="0"><br>'. $title .'</a><br><br>';
     
     $countfile = count($file)-1;

     $menu .= '<div style="display: none;" id="'. $modulename .'" align="center">';
     for($cz=1;$cz<=$countfile;$cz++)
      {
       $splitt = explode("|",$file[$cz]);
       $link = $splitt[0];
       $text = $splitt[1];

       $menu .= '<font class="p">&raquo;</font> <a href="'. $link .'#bottom">'. $text .'</a> <font class="p">&laquo;</font><br>';

      }
      $menu .= "</div>";
      $menu .= "</td>\r\n";
      }
      }
     $menu .= " </tr>\r\n";
     $menu .= "<tr><td colspan=\"$cols\">&nbsp;</td></tr>";
 }

$menu .= '</table><a name="bottom">';

TableAdmin("<a name=\"menu\">Menu</a>",$menu);
if(!$mode) {
include "admin/index.inc";
}
else {
include "admin/$mode.inc";
}
if($mode=="users" || $mode=="forum" || $mode=="smiley") {
}
elseif(!$action) {
nothing();
}
else {
$action();
}
closeTableMini();
closeSite();
?>
