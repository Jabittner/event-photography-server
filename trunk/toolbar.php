<?php

// Session code
session_start();
// Open a Database connection
include "DB.php";
include "functions.inc";
//print_r($_POST);
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
if($_POST['action']=="confirm")
{
$sql="update orders set phone=".$_POST['phone']." where orderid=".$_SESSION['orderid'];
mysql_query($sql);
?>
<table>
<tr><td>Order submitted,</td></tr>
<tr><td>Printing will occur after payment is made with the attendant. </td></tr>
<tr><td>Thank you for your business</td></tr>
</table>
<?php
session_destroy();

?>
	<script language="javascript">
	var sURL = unescape(window.location.pathname);
	var gURL = unescape(parent.mainFrame.location.pathname);
	function refresh()
	{
	    parent.window.location.replace( 'http://<?php echo $_SERVER['SERVER_ADDR']; ?>' );

	}

	</script>
<p><a href="javascript:refresh()">Reset Terminal</a></p>


<?php
die();
}
if($_POST['action']=="add")
{
$sql="INSERT INTO `orders` (  `event` , `photo` , `format` , `orderid` ) ";
$sql=$sql."VALUES ( '".$_POST['event']."', '".$_POST['photo']."', '".$_POST['format']."', '".$_SESSION['orderid']."')";
$result=mysql_query($sql);
}
if($_POST['action']=="rem")
{
$sql="delete from orders where itemnum=".$_POST['itemnum'];
mysql_query($sql);
}
if(!$_SESSION['orderid'])
{
// create a new order id
$sql="SELECT `orderid` FROM `orders` ORDER BY `orderid` DESC LIMIT 0 , 30";
$result=mysql_query($sql);
$array=mysql_fetch_row($result);
$orderid=$array[0]+1;
//$sql="INSERT INTO `orders` ( `itemnum` , `phone` , `event` , `photo` , `format` , `orderid` ) VALUES ('3', '5555555555', 'none', 'none', 'none', '".$orderid."')";
//$result=mysql_query($sql);
$_SESSION['orderid']=$orderid;
}
//echo $_SESSION['orderid']."<BR>";
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=POST name=order>
<input type=hidden name="action">
<input type=hidden name="itemnum">
<input type=hidden name="phone">
<input type=hidden name="event">
<input type=hidden name="photo">
<input type=hidden name="format">
<input type=hidden name="orderid">
</form>
<img src=/logo.gif width=200 height=200>

<?php
$sql="select * from orders where orderid=".$_SESSION['orderid'];
$result=mysql_query($sql);
if(!(mysql_num_rows($result)<1))
{
?>
<table>
<tr><TD colspan=4> <font size=5><b>Current Order<b></font></td></tr>
<tr><td></td><td>Size</td><td> Qty. </td><td>Remove</td></tr>
<?php
$sql="select * from orders where orderid=".$_SESSION['orderid'];
$result=mysql_query($sql);
while($array=mysql_fetch_array($result))
{
?>
<tr>
<td><a target="mainFrame" href="viewer.php?image=<?php echo $array['event']; ?>/<?php echo $array['photo']; ?>&event=<?php echo $array['event']; ?>&photo=<?php echo $array['photo']; ?>"><img src="/photos/<?php echo $array['event']; ?>/thumbs/<?php echo strtolower($array['photo']);?>" width=50 height=50></a></td><td><?php echo $array['format']; ?></td><td> 1 </td>
<td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=POST name=rem><input type=hidden name="itemnum" value="<?php echo $array['itemnum']; ?>" > <input type=hidden name=action value="rem"> <input type=submit value=X></form></td>

</tr>
<?php
}
?>
</table>


</table>
<hr>
To finalize order<BR>
Enter phone number<BR>
and Confirm:<BR>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=POST name=confirm>
<input type=hidden name="action" value="confirm">
<input type=text length=12 name="phone" > <BR>Ex: 9065555555<BR>
<input type=submit name="Confirm" value="Confirm">
</form>

<?php

} // this ends the condition to only show orders if greater than 0

?>
<hr>
<b>Step 1:</b> <BR>Browse Images and add to cart<BR>
<b>Step 2:</b> <BR>Enter Phone # and Finalize<BR>
<b>Step 3:</b> <BR>Pay for prints and pick them up<BR>
