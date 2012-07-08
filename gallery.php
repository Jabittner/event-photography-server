<?php
session_start();
// run some stuff
include "DB.php";
include "functions.inc";
/*
   
   This file is part of Event Photography Server.

    Event Photography Server is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation version 3 of the License.

    Event Photography Server  is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Event Photography Server.  If not, see www.gnu.org
*/
// Page Variables
$pagetitle = "Main";
//$maindir="/Applications/MAMP/htdocs/photos";
//print_r($_POST);

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
		
		createEventList();
		createfoot();
		break;
}

function createBrowse()
// needs an event in post
{
//print_r($_GET);
echo "<h2>Browsing ".$_GET['event']."</h2>";
echo "<font size=4><a href=\"gallery.php\"> Back </a></font>";
global $basedir;
$basedir=$basedir."/photos/".$_GET['event']."/";
$event=$_GET['event'];
$photolist=dirList($basedir);


echo "<table ><tr>";
$col=0;
foreach ($photolist as $photo)
	{
//		echo $basedir.$photo."<BR>";
		if(is_file($basedir.$photo))
		{
//			echo $basedir."thumbs/".$photo."<BR>";
			if(is_file($basedir."thumbs/".strtolower($photo)))
			{
//				echo "true";

				// This is the cell per picture
				?>
					<td>
						<table>
						<tr>
							<td><a href="viewer.php?image=<?php echo $event; ?>/<?php echo $photo; ?>&event=<?php echo $event; ?>&photo=<?php echo $photo; ?>"><img src="/photos/<?php echo $event.'/thumbs/'.strtolower($photo); ?>"> </a></td>
							<td> Add to Cart<BR>
							<a onclick="addphoto('<?php echo $event;?>', '<?php echo $photo;?>', '8x11');"> [ 8 x 11] </a> <BR>
							<a onclick="addphoto('<?php echo $event;?>', '<?php echo $photo;?>', '5x7');">[ 5 x 7 ] <BR>
							<a onclick="addphoto('<?php echo $event;?>', '<?php echo $photo;?>', 'Wallet');">[ Wallet Size ] <BR>
							<a onclick="addphoto('<?php echo $event;?>', '<?php echo $photo;?>', 'CD');">[ Add to CD ] <BR>
							</td>
						</tr>
						</table>
					</td>
				<?php
				$col++;
			} else {
//				echo "false";
// FOR BROWSE SCREEN ONLY... USE MAKETHUMBS FOR INITAL THUMBS
				if(is_dir($basedir."thumbs"))
				{
					saveThumbnail($basedir."thumbs/", $basedir.$photo, $photo, 200, 200);
				} else {
					mkdir($basedir."thumbs");
					saveThumbnail($basedir."thumbs/", $basedir.$photo, $photo, 200, 200);
				}

			}
		}
		if($col>=2)
			{
				echo "</tr><tr>";
				$col=0;
			}
	}
echo "</tr></table>";
}

function saveThumbnail($saveToDir, $imagePath, $imageName, $max_x, $max_y)
{
   preg_match("'^(.*)\.(gif|jpe?g|png)$'i", $imageName, $ext);
   switch (strtolower($ext[2])) {
       case 'jpg' :
       case 'jpeg': $im  = imagecreatefromjpeg ($imagePath);
                     break;
       case 'gif' : $im  = imagecreatefromgif  ($imagePath);
                     break;
       case 'png' : $im  = imagecreatefrompng  ($imagePath);
                     break;
       default    : $stop = true;
                     break;
   }

   if (!isset($stop)) {
       $x = imagesx($im);
       $y = imagesy($im);

       if (($max_x/$max_y) < ($x/$y)) {
           $save = imagecreatetruecolor($x/($x/$max_x), $y/($x/$max_x));
       }
       else {
           $save = imagecreatetruecolor($x/($y/$max_y), $y/($y/$max_y));
       }
       imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);

       imagejpeg($save, $saveToDir.strtolower($ext[1]).".jpg");
       imagedestroy($im);
       imagedestroy($save);
   }
}


function createEventList()
// Make a list of all events in /photos
{
global $basedir;
echo "<h2>Recently Photographed Events</h2><BR>";

	//echo $basedir."/photos<BR>";
$eventlist=dirList($basedir."/photos");



foreach ($eventlist as $event)
{
//echo $basedir."/photos/".$event."/thumbs";

if(is_dir($basedir."/photos/".$event."/thumbs"))
{
	$thumblist=dirList($basedir."/photos/".$event."/thumbs");
	$length=count($thumblist);
        if($length!=1){ 
                $rand=rand(1, $length-1);
        } else {
		$rand=0;
	}
	//$rand=rand(1, $length);
	$ranphoto=$event."/thumbs/".$thumblist[$rand];
	//echo $length;
} else {
// need to generate thumbs
$ranphoto="missing.gif";
makethumbnails($event);
	$thumblist=dirList($basedir."/photos/".$event."/thumbs");
	$length=count($thumblist);
	if($length!=1){ 
		$rand=rand(1, $length-1);
	} else {
		$rand=0;
	}
	$ranphoto=$event."/thumbs/".$thumblist[$rand];
}
?>
<table><tr><td width=201><center><a href="gallery.php?action=event&event=<?php echo urlencode($event); ?>">
<img src="/photos/<?php echo $ranphoto; ?>">
<font size=4><B><?php echo $event; ?></b></font></center> </a>
</td>
<td>><a href="gallery.php?action=event&event=<?php echo urlencode($event); ?>">Browse Photos</a><br><BR>
><a href="slideshow.php?event=<?php echo urlencode($event); ?>">Play Slideshow</a>
</td></tr>


</table>


<br><BR><BR>

<?php
}

}

function dirList ($directory)
// List all of the files in the directory photos
{

    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // keep going until all files in directory have been read
    while ($file = readdir($handler)) {

        // if $file isn't this directory or its parent,
        // add it to the results array
        if ($file != '.' && $file != '..' && $file != 'missing.gif' && $file != '.DS_Store' )
            $results[] = $file;
    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;

}


function createhead() {
	global $ScriptName;
	global $HTTP_HOST;


?>
			<script language=javascript>
			function addphoto(event, photo, format)
		{
				parent.leftFrame.document.order.event.value=event;
				parent.leftFrame.document.order.photo.value=photo;
				parent.leftFrame.document.order.format.value=format;
				parent.leftFrame.document.order.action.value='add';
				parent.leftFrame.document.order.submit();


		}

		</script>

			<?php
}
function makethumbnails($event) {
global $basedir; 

$eventdir=$basedir."/photos/".$event."/";
$photolist=dirList($eventdir);


foreach ($photolist as $photo)
	{
//		echo $eventdir.$photo."<BR>";
		if(is_file($eventdir.$photo))
		{
//			echo $eventdir."thumbs/".$photo."<BR>";
			if(is_file($eventdir."thumbs/".strtolower($photo)))
			{
//				echo "true";
				// This file exists
			} else {
				// No thumbnail exists
//				echo "false";
				if(is_dir($eventdir."thumbs"))
				{
					saveThumbnail($eventdir."thumbs/", $eventdir.$photo, $photo, 200, 200);
				} else {
					mkdir($eventdir."thumbs");
					saveThumbnail($eventdir."thumbs/", $eventdir.$photo, $photo, 200, 200);
				}
				
				$sql="INSERT INTO `ddog`.`stats` (`event` ,`photo` , `date`) VALUES ('".$event."', '".$photo."', NOW( ));";
				$result=mysql_query($sql);
				//echo $sql."<BR>";
			}
		}

	}

}

function createfoot() {
	?>
	<center><font size="2"> </font></center>
	</body>
	</html>
	<?php
}
?>
