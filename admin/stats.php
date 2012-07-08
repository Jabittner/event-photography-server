
<?php
// Statistics of viewing
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
</td></tr></table>
<HR>
<table><tr>
<TD width=650>
<h2>Photo Viewing Statistics</h2><BR>
TOP 30<BR>
<table>
<tR><td>Views</td><td>Thumbnail</td></tr>
<?php
$sql="select * from stats order by count DESC limit 20";
$result=mysql_query($sql);
while($array=mysql_fetch_array($result))
{
echo '<tr><td>'.$array['count'].'</td>';
echo '<td><a href="../viewer.php?image='.$array['event'].'/'.$array['photo'].'&event='.$array['event'].'&photo='.$array['photo'].'" target=_blank>';

echo '<img width=100 height=100 src="/photos/'.$array['event'].'/thumbs/'.strtolower($array['photo']).'"></a></td></tr>';

}
?>
</table>


</td><td width=200 valign=top><img src=/logo.gif width=200 height=200>
</td></tr></table>
