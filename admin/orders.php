
<?php
// orders retrival system
include "../DB.php";
include "../functions.inc";
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
<body>
<table><tr><TD> Admin Features: </td><td> <a href="/admin/orders.php"> Order Viewer </a>
</td><td>
<a href="/admin/stats.php"> Viewing Statistics</a> 
</td></tr></table><HR>

<table><tr>
<TD width=650 valign=top><h2>Order Retrevial</h2>
<table>
<tr><td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=POST name=order>
</td></tr>
<tr><td>Phone number: <input type=text name=phone length=12 onload="window.focus();"></td></tr>
<tr><td><input type=hidden name=action value=lookup><input type=submit value="Lookup Order"></form></td></tr>
</table>
<HR>

<?php
if($_POST['action']=="editstatus")
{
//echo "Changing status to:".$_POST['status']." for ".$_POST['itemnum'];
$sql="update orders set status ='".$_POST['status']."' where itemnum=".$_POST['itemnum']." limit 1";
$result=mysql_query($sql);

}



if($_POST['action']=="lookup" || $_POST['action']=="editstatus")
{
$sql="select * from orders where phone=".$_POST['phone'];
$result=mysql_query($sql);
?>
Results found for: <?php echo $_POST['phone']; ?><BR>
<table border="5">
<tr><TD><B>Thumbnail</b></td><Td><b>Event</b></td><td><b>Photo</b></td><td><b>Format</b></td><td><b>Status</b></td><td><b>Change Status</b></td>
<?php
while($array=mysql_fetch_array($result))
	{
	?>
<tr
<?php
if($array['status']=="cancel")
{
echo " bgcolor=red ";
} elseif($array['status']=="printed")
{
echo " bgcolor=lightgreen ";
} elseif($array['status']=="pickedup")
{
echo " bgcolor=grey ";
} else {
echo " bgcolor=white ";
}
?>><td><img width=100 height=100 src="/photos/<?php echo $array['event'] ?>/thumbs/<?php echo strtolower($array['photo']); ?>"></td><Td><?php echo $array['event']; ?></td><td><?php echo $array['photo']; ?></td><td><?php echo $array['format']; ?></td><td><b><?php echo $array['status']; ?></b></td><td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=POST name=order><input type=hidden name=action value=editstatus><input type=hidden name=itemnum value=<?php echo $array['itemnum']; ?>><input type=hidden name=phone value=<?php echo $_POST['phone']; ?>><input type=submit name=status value=printed> <input type=submit name=status value=cancel><BR><BR> <input type=submit name=status value=pickedup><input type=submit name=status value=created></form></td></tr>
<?php
	}
	?>
</table>
<?php
}
?>
</td><td width=200><img src=/logo.gif width=200 height=200>
</td></tr></table>
