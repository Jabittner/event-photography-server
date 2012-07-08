<?php
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
?>
<html>
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
<body>

<h3> <a href="gallery.php?action=event&event=<?php echo $_GET['event']; ?>">Back to Event</a></h3>
							Add to Cart:  <a onclick="addphoto('<?php echo $_GET['event'];?>', '<?php echo $_GET['photo'];?>', '8x11');"> [ 8 x 11] </a> 
							<a onclick="addphoto('<?php echo $_GET['event'];?>', '<?php echo $_GET['photo'];?>', '5x7');"> [ 5 x 7 ] </a>
							<a onclick="addphoto('<?php echo $_GET['event'];?>', '<?php echo $_GET['photo'];?>', 'Wallet');"> [ Wallet Size ] </a>
							<a onclick="addphoto('<?php echo $_GET['event'];?>', '<?php echo $_GET['photo'];?>', 'CD');"> [ Add to CD ] </a><BR>
<?php

// storage <a href="#" onClick="history.go(-1)">Previous Page</a>
// Load image into im tag
include "db.php"; //no database needed here
global $basedir;
$imageName=$_GET['image'];
$imagePath=$basedir."/photos/".$_GET['image'];
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
// Get sizes of image
$x = imagesx($im);
$y = imagesy($im);

$ratio=$x/$y; 
if($y>525)
{
	$y_max=525; 
	$x_max=$ratio*$y_max;
	}else{
	$y_max=$y; 
	$x_max=$x;
	}
	
?>

<img width=<?php echo $x_max; ?> height=<?php echo $y_max; ?> src="photos/<?php echo $_GET['image'];?>">

<?php
$sql="select count,imageid from stats where photo='".$_GET['photo']."' and event='".$_GET['event']."' limit 1;";
//echo $sql."<BR>";
$result=mysql_query($sql);
$array=mysql_fetch_array($result);
$count=$array['count']+1;
$sql="update stats set count=".$count." where imageid=".$array['imageid']." limit 1";
//echo $sql."<BR>";
$result=mysql_query($sql);

?>
</body>
</html>
