<?php
session_start();
// run some stuff
include "DB.php";
include "functions.inc";

// Page Variables
$pagetitle = "Main";


// The Action variables define the next functions.
// Order of precidence, jscript, post, get icky get allowed
if($_POST['jaction']!=Null){
	$action=$_POST['jaction'];
}else{
	if($_POST['action']!=NULL){
        $action=$_POST['action'];
	}else{
		if($_GET['action']!=NULL){
			$action=$_GET['action'];
		}else {
	        $action="null";
		}
	}
}
//echo $action;
switch ($action){

	case "event":
		createhead();
		createBrowse();
		createfoot();
		break;

	case "null":
		createhead();
		
		createInstallForm();
		createfoot();
		break;
}

function RunInstall(){

$link = mysql_connect($_POST['host'], $_POST['user'], $_POST['pass']);
if (!$link) {
    die('INSTALL FAILED: Could not connect Root Mysql User/Pass Error: ' . mysql_error());
}
echo 'Connected successfully';

$sql = 'CREATE DATABASE '.$_POST['database'];
if (mysql_query($sql, $link)) {
    echo "Database ".$_POST['database']." created successfully\n";
} else {
    echo 'Error creating database: ' . mysql_error() . "\n";
    die('INSTALL FAILED: Could not create Database');
}

if(mysql_query("source install.sql")) {
	echo "Database Loaded Successfully";
} else {
    die('INSTALL FAILED: Could not Load Database');
}

/*
// make directorys
if (mkdir($_POST['DOCUMENT_ROOT']."/photos/", 0777)) {
	echo "Photo Directory Created";
} else {
	die('INSTALL FAILED: could not create photo directory');
}

// make directorys
if (mkdir($_POST['DOCUMENT_ROOT']."/photos/TestEvent", 0777)) {
	echo "TestEvent Directory Created";
} else {
	die('INSTALL FAILED: could not create photo directory');
}

*/
// all of this is directly from php.net

$filename = 'conf.php';
$somecontent = "<?php \n $basedir=$_SERVER['DOCUMENT_ROOT']; \n";

$somecontent = $somecontent. "error_reporting(E_ALL ^ E_NOTICE); \n";
$somecontent = $somecontent. "$host=$_POST['host']; \n";
$somecontent = $somecontent. "$user=$_POST['user']; \n";
$somecontent = $somecontent. "$pass=$_POST['pass']; \n";
$somecontent = $somecontent. "$database=$_POST['database']; \n \?\>";


if (is_writable($filename)) {

    if (!$handle = fopen($filename, 'w+')) {
         echo "Cannot open file ($filename)";
         exit;
    }
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
    fclose($handle);
} else {
    echo "The file $filename is not writable";
}





mysql_close($link);



}

function createInstallForm(){
?>
<BR>Defaults Should work just fine for a installing onto MAMP with default Server Ports Selected! <BR>

<form action=<?phpecho $_SERVER['PHP_SELF']; ?>  method=POST name=order>
<input type=hidden name=action value=installrun>
<BR>
Script Installed Location: <input type=text name=location value="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>"><BR>
<h3>Mysql Setup Section:</h3><BR> 
Mysql Host:<input type=text name=host value="localhost"><br>
Mysql Database: <input type=text name=database value="EventPhoto"><BR>
Mysql Root User: <input type=text name=user value="root"><BR>
Mysql Root Pass: <input type=text name=pass value="root"><BR>
Mysql Table: <input type=text name=table value="EventPhoto"><BR>
(Passwords are randomly created because we can just use http://localhost/MAMP for DB administration. )<BR>
<input type=submit name=submit value=Install></form>
<?php
}


function createhead() {
	global $ScriptName;
	global $HTTP_HOST;

echo "<h2> EventPhoto Server Install Screen</h2>";

}
function createfoot() {
	?>
	<center><font size="2"> </font></center>
	</body>
	</html>
	<?php
}
?>