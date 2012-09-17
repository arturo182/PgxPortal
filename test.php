<?
$hostname           = "localhost";
$dbName             = "pgx";
$username           = "globus";
$passwrd            = "mistrz";
$db_prefix          = "pgxportal_";

@mysql_connect($hostname,$username,$passwrd) OR DIE("Nie mozna sie polaczyc z baza danych.");
@mysql_select_db($dbName) or die("Nie mo¿na wybrac bazy.");

$pgxuser == "GLOBUS";

mysql_query("UPDATE ". $db_prefix ."member SET posts=posts-1 WHERE username='$pgxuser'");
?>
