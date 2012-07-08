<?php

// This functions file will serve as a bridge between the public files
// and the admin files, best
// to place the non-sensitive functions within this file and call from here. 
// -jim 5/11/05
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

function FetchNPrint($parent, $isedit, $table)
// This function will grab all rows whose parent is provided and print them out *Null Allowed*
{
	//$debug=1;
	
	// Makes this function able to double as a edit table.
	if (!isset($isedit))
	{
		$edit=0;
	}
	// Main Sql Format for menu parent is passed in above (default 0)
	$sql="SELECT ID, Name, Href FROM ".$table." WHERE Parent=".$parent.";";

	$result=mysql_query($sql);

	// loop for all items in that parents layer
	while($base=mysql_fetch_array($result))
	{
		// Build a link, and attach the toolbar id to be used as a _GET
		echo "<a href=".$base['Href']."?toolbar=".$base['ID']." target=\"mainFrame\">".$base['Name']."</a>";
		
		// This makes a link to have the screen use javascript to jump to edit the id
		if($isedit==1)
		{
		echo "<a onclick=\"id_jump(".$base['ID'].", 'update');\"> EDIT </a> <a onclick=\"id_jump(".$base['ID'].", 'delete');\"> Delete </a>";
		}
		
		echo "<BR>";
		
		// Find if child item has any child items of its own
		// What no birth control, by god!
		$child=mysql_query('SELECT * FROM '.$table.' WHERE Parent='.$base['ID'].';');
		if(isset($debug))
		{
				echo "<BR>".mysql_num_rows($child);
				echo "<br>";
		}
		
		// If there are actually rows returned spawn another process out of love.
		if(mysql_num_rows($child)!=0)
		{
			$child=mysql_fetch_array($child);
			FetchNPrint($child['Parent'], $isedit, $table);
		}
	}

}
// if you reach this then, by god recursion worked.

function mysqlscrub($arr)
// This function will scrub an array of variables to be prepped for mysql input
{
foreach ($arr as $key => $value) {
		$value = mysql_real_escape_string($value);
	}
	return $arr;
}


function mysqlscrubstring($value)
// This function will scrub an array of variables to be prepped for mysql input
{
	$value = mysql_real_escape_string($value);
	return $value;
}


function MysqlQuoteArray($array, $seperator, $IsContent){
// This function is to take an array Eg: $_POST
// And dump it's contents into a mysql table, so
// there is an asston of assumptions made: sql table has these columns
// the values are all propperly defined etc... 
	
// Run through each item	
foreach($array as $key => $string)
{
	// Make some real checks not to include the action variable
	// Also can be edited to include other non-input form data
	if($key!="action")
	{
		
		// Start putting each chunk together
		
			// Define wither it is a array of keys or a array of content strings
			if($IsContent==1)
			{
				// rub a dub dub scrub the varialbub. 
				$string=mysqlscrubstring($string);
				
				// This will provide support to encode passwords, note the CASE
				if($key=="Password")
				{
					$complete=$complete." password('".$string."') ";

				} else {
					$complete=$complete."'";
					$complete=$complete.$string;
					$complete=$complete."'";
				}
			}else{
				// loop to build the array of keys
				$complete=$complete."`";
				$complete=$complete.$key;
				$complete=$complete."`";
			}
		// Finish it up
		$complete=$complete.$seperator;
	}
}

// This removes the last comma from the string
return substr($complete, 0, (strlen($complete)-2));
}


function MysqlQuoteArrayUpdate($array, $seperator){
// This function builds the SQL statement out of an array 
	
	// Run through each item	
	foreach($array as $key => $string)
	{
		
		// Make some real checks not to include the action variable
		if($key != "action")
		{
			
			$string=mysqlscrubstring($string);
			if ($key=="Password" && $string=='')
			{
			// Then do noting it will not be updated in this query
			} else {
				// Start putting each chunk together
				$complete=$complete."`";
				// Define wither it is a key or a content string
				$complete=$complete.$key;
				$complete=$complete."` = ";
			}
			// Now we need to support encoding passwords
			if($key=="Password")
			{
				if($string!='')
				{
					$complete=$complete." password('".$string."') ";
				}
			} else {
			$complete=$complete."'";
			$complete=$complete.$string;
			$complete=$complete."'";
			}
			
			// Finish it up
			//$complete=$complete."'";
			if($key=="Password" && $string=='')
			{ // do nothing
			} else {
			$complete=$complete.$seperator;
			}
		}
	}
	
	// This removes the last comma from the string
	return substr($complete, 0, (strlen($complete)-(strlen($seperator))));
}
	

function MysqlInsert($values, $table){
// Build a SQL Insert statement out of an named array eg: post
// MysqlInsert(array("Name" => "Johnson", "Href" => "index.html", "Parent" => "35"),"Toolbar")
	$sql="Insert INTO `".$table."` (".MysqlQuoteArray($values, ", ", 0).")";
	$sql=$sql."VALUES (".MysqlQuoteArray($values, ", ",1).");";
	return $sql;
}
	
function MysqlUpdate($values, $index, $table){
// Build a SQL Update statement out of an named array and named index 
// MysqlUpdate(array("Name" => "Johnson", "Href" => "index.html", "Parent" => "35"), array("ID"=>"2"),"Toolbar");

	$sql="UPDATE `".$table."` SET ".MysqlQuoteArrayUpdate($values, ", ")." WHERE ".MysqlQuoteArrayUpdate($index, " and ").";";
	return $sql;
}

?>