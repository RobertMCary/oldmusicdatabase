<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Update a track</title>
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
$trackID="";
$fldValue="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $trackID = $_POST["txtTrackID"];
    $fldValue = $_POST["txtValue"];
    
    //take care of any html characters including quotes (double and single)
    $trackID = htmlentities($trackID, ENT_QUOTES);
    $fldValue = htmlentities($fldValue, ENT_QUOTES);

    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element
	
	$changeValue = $_POST["lstField"];
	if($changeValue=="fldTrackNum"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the track number";
    	} else {
        	$valid = verifyNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The track number must be numbers only.";
        	}
    	}
    } else if($changeValue=="fldProducer"){
		if($fldValue==""){
        	$errorMsg[]="Please enter the producer";
    	} else {
        	$valid = verifyProducer ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The producer must be letters, numbers, spaces, dashes and single quotes  only.";
        	}
    	}
    } else if($changeValue=="fldTrackTitle"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the track title";
    	} else {
        	$valid = verifyTrack ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The track title must be letters, numbers, parentheses, spaces, and single quotes only.";
        	}
    	}
    } else if($changeValue=="fldKey"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the key";
    	} else {
        	$valid = verifyKey ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The key must be letters and/or a # if necessary only.";
        	}
    	}
    } else if($changeValue=="fldBPM"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the BPM";
    	} else {
        	$valid = verifyNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The BPM must be numbers only.";
        	}
    	}
    } else if($changeValue=="fldGenre"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the genre";
    	} else {
        	$valid = verifyGenre ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The genre must be letters, numbers, spaces, dashes, and single quotes only.";
        	}
    	}
    } else if($changeValue=="fldDuration"){
    	if($fldValue==""){
        	$errorMsg[]="Please enter the duration";
    	} else {
        	$valid = verifyNum ($changeValue); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The track number must be numbers only.";
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
        
        if ($changeValue=="fldTrackTitle"){
        	$sql = "UPDATE tblTrack SET " . $changeValue . "='" . $fldValue . "' WHERE pkTrackID='" . $trackID . "'";
        	$myData = mysql_query($sql,$connectID);
        	$sql = "UPDATE tblReleaseTrack SET fkTrackTitle='" . $fldValue . "' WHERE fkTrackID='" . $trackID . "'";
        	$myData = mysql_query($sql,$connectID);
        } else {
        	$sql = "UPDATE tblTrack SET " . $changeValue . "='" . $fldValue . "' WHERE pkTrackID='" . $trackID . "'";
        	$myData = mysql_query($sql,$connectID);
        }
        
        $sql = "SELECT fkCatNum FROM tblReleaseTrack WHERE fkTrackID='" . $trackID . "'";
        $myData = mysql_query($sql,$connectID);
        $catNum = mysql_fetch_array($myData);
        echo "<p>Update successful. Click <a href='/~rcary/cs148/finalproject/browse/releasePage.php?CatNum=" . $catNum[0] . "'>here</a> to clarify.</p>";
        
        print "</div>";
    }
}
?>
<form action="" id="frmUpdateTrack" method="post" style="text-align:center">
        <fieldset>
            <label for="txtTrackID">Track ID*</label><br />
            <input name="txtTrackID" type="text" size="2" id="txtTrackID" <? print "value='$trackID'"; ?>/><br /><br />
            
            <label for="lstField">Update which field?</label><br />
            <select id="lstField" name="lstField" size="1">
            	<option value="fldTrackNum">Track number</option>
            	<option value="fldProducer">Producer</option>
            	<option value="fldTrackTitle">Track Title</option>
            	<option value="fldKey">Key (Am, C#M, etc.)</option>
            	<option value="fldBPM">BPM</option>
            	<option value="fldGenre">Genre</option>
            	<option value="fldDuration">Duration (mm:ss)</option>
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