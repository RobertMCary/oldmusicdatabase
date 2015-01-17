<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Add tracks to a release</title>
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

$fkCatNum="";
$trackTitle="";
$producer="";
$genre="";
$key="";
$bpm="";
$duration="";
$trackNum="";
$YTLink="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $fkCatNum = $_POST["txtCatNum"];
    $trackTitle = $_POST["txtTrackTitle"];
    $producer = $_POST["txtProducer"];
    $genre = $_POST["txtGenre"];
    $key = $_POST["txtKey"];
    $bpm = $_POST["txtBPM"];
    $duration = $_POST["txtDuration"];
    $trackNum = $_POST["txtTrackNum"];
    $YTLink = $_POST["txtYTLink"];
    
    //take care of any html characters including quotes (double and single)
    $fkCatNum = htmlentities($fkCatNum, ENT_QUOTES);
    $trackTitle = htmlentities($trackTitle, ENT_QUOTES);
    $producer = htmlentities($producer, ENT_QUOTES);
    $genre = htmlentities($genre, ENT_QUOTES);
    $key = htmlentities($key, ENT_QUOTES);
    $bpm = htmlentities($bpm, ENT_QUOTES);
    $duration = htmlentities($duration, ENT_QUOTES);
    $trackNum = htmlentities($trackNum, ENT_QUOTES);
    $YTLink = htmlentities($YTLink, ENT_QUOTES);

    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element 
	if($fkCatNum==""){
        $errorMsg[]="Please enter the catalog number you want to add tracks to";
    } else {
        $valid = verifyAlphaNum ($fkCatNum); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The catalog number must be letters and numbers, spaces, dashes, ', and parentheses only.";
        }
    }
	
    if($trackTitle==""){
        $errorMsg[]="Please enter the track title";
    } else {
        $valid = verifyTrack ($trackTitle); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The track title must be letters and numbers, spaces, dashes, ', and parentheses only.";
        }
    }
    
    if($producer==""){
        $errorMsg[]="Please enter the producer";
    } else {
        $valid = verifyProducer ($producer); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The producer must be letters and numbers, spaces, dashes and ' only.";
        }
    }

	if($genre==""){
        $errorMsg[]="Please enter the genre";
    } else {
        $valid = verifyGenre ($genre); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The genre must be letters and spaces only.";
        }
    }
    
    if($key==""){
    	$errorMsg[]="Please enter the key";
    } else {
    	$valid = verifyKey ($key);
    	if (!$valid){
    		$error_msg[]="Key must be letters only, # if necessary.";
    	}
    }
    
    if($bpm==""){
    	$errorMsg[]="Please enter the BPM (beats per minute)";
    } else {
    	$valid = verifyNum ($bpm);
    	if (!$valid){
    		$error_msg[]="BPM must be numbers only.";
    	}
    }
    
    if($trackNum==""){
    	$errorMsg[]="Please enter the track number";
    } else {
    	$valid = verifyNum ($trackNum);
    	if (!$valid){
    		$error_msg[]="The track number must be numbers only.";
    	}
    }
    
    /*
    if($YTLink==""){
    	$errorMsg[]="Please enter the YouTube link";
    } else {
    	$valid = verifyMediaURL ($YTLink);
    	if (!$valid){
    		$error_msg[]="The YouTube link must be an actual YouTube link!";
    	}
    }
    */
    
    $sql = "SELECT fkCatNum FROM tblReleaseTrack WHERE fkCatNum='" . $fkCatNum . "'";
    $exists = mysql_query($sql,$connectID);
    $numRows = mysql_num_rows($exists);
    if($numRows==0){
    	$errorMsg[]="This release does not exist!";
    }
    
    $sql = "SELECT fkTrackID FROM tblReleaseTrack WHERE fkCatNum='" . $fkCatnum . "'";
    $trackExists = mysql_query($sql,$connectID);
    $trackList = mysql_fetch_array($trackExists);
    $numRows = mysql_num_rows($trackExists);
    for ($i=0;$i<$numRows;$i++){
    	$sql = "SELECT fldTrackTitle FROM tblTrack WHERE pkTrackID='" . $trackList[$i] . "'";
    	$exists = mysql_query($sql,$connectID);
    	$track = mysql_fetch_array($exists);
    	if($trackTitle==$track[0]){
    		$errorMsg[]="This track already exists!";
    	}
    }
    
    $sql = "SELECT fldNumTracks FROM tblRelease WHERE pkCatNum='" . $fkCatNum . "'";
    $myData = mysql_query($sql,$connectID);
    $totalTracks = mysql_fetch_array($myData);
    $total = $totalTracks[0];
    if ($numRows == $total){
    	$errorMsg[]="This release is full! You cannot add more tracks unless you delete some.";
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
        echo "<p>Upload successful. Click <a href='/~rcary/cs148/finalproject/browse/releasePage.php?CatNum=" . $fkCatNum . "'>here</a> to see the addition.</p>";
        
        $sql = "INSERT INTO tblTrack SET ";
        $sql .= "fldProducer='" . $producer . "', ";
        $sql .= "fldTrackTitle='" . $trackTitle . "', ";
        $sql .= "fldGenre='" . $genre. "', ";
        $sql .= "fldKey='" . $key . "', ";
        $sql .= "fldBPM='" . $bpm . "', ";
        $sql .= "fldTrackNum='" . $trackNum . "', ";
        $sql .= "fldYTLink='" . $YTLink . "', ";
        $sql .= "fldDuration='" . '00:' . $duration ."'";
        $myData = mysql_query($sql,$connectID);
        
        $sqlTrackID = "SELECT pkTrackID FROM tblTrack WHERE fldTrackTitle='" . $trackTitle . "'";
        $trackQuery = mysql_query($sqlTrackID,$connectID);
        $trackID = mysql_fetch_row($trackQuery);
        
        $sql2 = "INSERT INTO tblReleaseTrack SET ";
        $sql2 .= "fkCatNum='" . $fkCatNum . "', ";
        $sql2 .= "fkTrackID='" . $trackID[0] . "', ";
        $sql2 .= "fkTrackTitle='" . $trackTitle . "'";
        $myData2 = mysql_query($sql2,$connectID);
        
        $sql = "DELETE FROM tblReleaseTrack WHERE (fkCatNum='" . $fkCatNum . "' AND fkTrackID='0')";
        $myData = mysql_query($sql,$connectID);
    }
}
?>
	<form action="" id="frmTracks" method="post" style="text-align:center">
        <fieldset>
            <label for="txtCatNum">Catalog Number*</label><br />
            <input name="txtCatNum" type="text" size="15" id="txtCatNum" <? print "value='$fkCatNum'"; ?>/><br />
            
            <label for="txtTrackNum">Track Number*</label><br />
            <input name="txtTrackNum" type="text" size="2" id="txtTrackNum" <? print "value='$trackNum'"; ?>/><br />
            
            <label for="txtTrackTitle">Track Title*</label><br />
            <input name="txtTrackTitle" type="text" size="50" id="txtTrackTitle" <? print "value='$trackTitle'"; ?>/><br />
             
            <label for="txtProducer">Producer* (list in alphabetical order, separate with an ampersand)</label><br />
            <input name="txtProducer" type="text" size="50" id="txtProducer" <? print 'value="' . $producer . '"'; ?>/><br />
     
            <label for="txtGenre">Genre* (full name please)</label><br />
            <input name="txtGenre" type="text" size="30" id="txtGenre" <? print "value='$genre'"; ?> /><br />
     
     		<label for="txtKey">Key (Ex: Am = A minor; A#M = A# major)*</label><br />
     		<input name="txtKey" type="text" size="3" id="txtKey" <? print "value='$key'"; ?> /><br />
     		
     		<label for="txtBPM">BPM*</label><br />
     		<input name="txtBPM" type="text" size="3" id="txtBPM" <? print "value='$bpm'"; ?> /><br />
     		
     		<label for="txtDuration">Duration (06:34 = 6 minutes 34 seconds)</label><br />
     		<input name="txtDuration" type="text" size="6" id="txtDuration" <? print "value='$duration'"; ?> /><br />
     		
     		<label for="txtYTLink">YouTube Link</label><br />
     		<input name="txtYTLink" type="text" size="30" id="txtYTLink" <? print "value='$YTLink'"; ?> /><br />
           
            <input type="submit" name="cmdSubmitted" value="Add it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>

<?php include("menubar.php"); ?>
</body>
</html>