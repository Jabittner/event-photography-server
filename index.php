<?php
// This is the main viewer file
// Do with what you'd like
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
<?php
session_start();
?>
<HTML>
<HEAD>
<TITLE> Event Photography Service</TITLE>
</HEAD>

<frameset cols="223,*" border="0" frameborder="0" framespacing="0" id="MainFrameSet">
	<frame src="toolbar.php" id="leftFrame" name="leftFrame" frameborder="0" border="0" noresize>
	<frame src="gallery.php" id="mainFrame" name="mainFrame" frameborder="0" border="0" framespacing="0" noresize scrolling="auto">
</frameset>

</html>
	<?php
//print_r($_SESSION);
?>
