<?php
// Run a slideshow given _get'event
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

global $basedir; 

$eventdir=$basedir."/photos/".$_GET['event']."/";
$photolist=dirList($eventdir);
?>
<html>
<body>
<?php
echo '<img width=400 height=400 name=mainphoto src="/photos/'.$_GET['event'].'/'.$photolist[0].'">';
?>

<script langugage="javascript">
$x=sleep(500);
document.mainphoto.src='/photos/missing.gif';
</script>


<?php
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


?>
</body>
</html>