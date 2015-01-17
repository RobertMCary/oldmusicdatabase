<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Update a release</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Rob Cary" />
<meta name="description" content="The internet home of DJ Nightowl" />

<link rel="stylesheet" href="/~rcary/cs148/finalproject/ss/NOdefault.css" type="text/css" title="nighttime" media="screen" />
<link rel="alternate stylesheet" href="/~rcary/cs148/finalproject/ss/NOdaytime.css" type="text/css" title="daytime" media="screen" />
<link rel="alternate stylesheet" href="/~rcary/cs148/finalproject/ss/NOtropical.css" type="text/css" title="tropical" media="screen" />
<link rel="alternate stylesheet" href="/~rcary/cs148/finalproject/ss/NOdarkness.css" type="text/css" title="darkness" media="screen" />

<script src="cookies.js" type="text/javascript"></script>

<script src="/~rcary/cs148/finalproject/styleCheck.js" type="text/javascript"></script>
</head>
<body>
<div id="browsemenu">
<?php
$catNum="";
$fldValue="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $catNum = $_POST["txtCatNum"];
    $fldValue = $_POST["txtValue"];
    
    //take care of any html characters including quotes (double and single)
    $catNum = htmlentities($catNum, ENT_QUOTES);
    $fldValue = htmlentities($fldValue, ENT_QUOTES);

    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element
	
	$changeValue = $_POST["lstField"];
	if($changeValue=="pkCatNum"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the catalog number";
    	} else {
        	$valid = verifyAlphaNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The catalog number must be letters, numbers, spaces, dashes and single quotes only.";
        	}
    	}
    } else if($changeValue=="fldReleaseTitle"){
		if($fldValue==""){
        	$errorMsg[]="Please enter the release title";
    	} else {
        	$valid = verifyAlphaNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The release title must be letters, numbers, spaces, dashes and single quotes only.";
        	}
    	}
    } else if($changeValue=="fldLabel"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the label";
    	} else {
        	$valid = verifyAlphaNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The label must be letters, numbers, spaces, dashes and single quotes only.";
        	}
    	}
    } else if($changeValue=="fldFormat"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the format";
    	} else {
        	$valid = verifyAlphaNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The format must be letters, numbers, spaces, dashes and single quotes only.";
        	}
    	}
    } else if($changeValue=="fldReleaseDate"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the release date";
    	} else {
        	$valid = verifyPhone ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The release date must be numbers and dashes only.";
        	}
    	}
    } else if($changeValue=="fldNumTracks"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the number of tracks";
    	} else {
        	$valid = verifyNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The number of tracks must be a number!";
            }
    	}
    } else if($changeValue=="fldComments"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the comments";
    	} else {
        	$valid = verifyAlphaNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The comments must be letters, numbers, spaces, dashes, and single quotes only.";
        	}
    	}
    }
    
    if($errorMsg){
        echo "<ul>\n";
        foreach($errorMsg as $err){
            echo "<li style='color: #ff6666'>" . $err . "</li>\n";
        }
        echo "</ul>\n";
    } else {
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// form is valid now we need to save information to the database
        
        if ($changeValue=="pkCatNum"){
       		$sql = "UPDATE tblRelease SET " . $changeValue . "='" . $fldValue . "' WHERE pkCatNum='" . $catNum . "'";
       		$myData = mysql_query($sql,$connectID);
       		$sql = "UPDATE tblReleaseTrack SET fkCatNum='" . $fldValue. "' WHERE fkCatNum='" . $catNum . "'";
       		$myData = mysql_query($sql,$connectID);
       		echo "<p>Update successful. Click <a href='/~rcary/cs148/finalproject/browse/releasePage.php?CatNum=" . $fldValue . "'>here</a> to clarify.</p>";
       	} else {
        	$sql = "UPDATE tblRelease SET " . $changeValue . "='" . $fldValue . "' WHERE pkCatNum='" . $catNum . "'";
        	$myData = mysql_query($sql,$connectID);
        	echo "<p>Update successful. Click <a href='/~rcary/cs148/finalproject/browse/releasePage.php?CatNum=" . $catNum . "'>here</a> to clarify.</p>";
        }
        
        print "</div>";
    }
}
?>
<form action="" id="frmUpdateRelease" method="post" style="text-align:center">
        <fieldset>
            <label for="txtCatNum">Catalog Number*</label><br />
            <input name="txtCatNum" type="text" size="15" id="txtCatNum" <? print "value='$catNum'"; ?>/><br /><br />
            
            <label for="lstField">Update which field?</label><br />
            <select id="lstField" name="lstField" size="1">
            	<option value="pkCatNum">Catalog Number</option>
            	<option value="fldReleaseTitle">Release Title</option>
            	<option value="fldLabel">Label</option>
            	<option value="fldFormat">Format (12I, MP3, etc.)</option>
            	<option value="fldReleaseDate">Release Date (yyyy-mm-dd)</option>
            	<option value="fldBeatLink">Beatport link</option>
            	<option value="fldNumTracks"># of tracks</option>
            	<option value="fldComments">Comments</option>
            </select><br /><br />
            
            <label for="txtValue">Update selected field with:</label><br />
            <input name="txtValue" type="text" size="100" id="txtValue" <? print "value='$fldValue'"; ?>/><br /><br />
           
            <input type="submit" name="cmdSubmitted" value="Update it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>
<?php include("menubar.php"); ?>
</body>
</html>