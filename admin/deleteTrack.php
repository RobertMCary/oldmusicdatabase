<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Delete a track</title>
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
$pkTrackID="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdDeleteSubmit"])){
    // initialize my variables to the forms posting    
    $pkTrackID = $_POST["txtTrackID"];
    //take care of any html characters including quotes (double and single)
    $pkTrackID = htmlentities($pkTrackID, ENT_QUOTES);
    include ("validation_functions.php");
    $errorMsg=array();
    
    	if($pkTrackID==""){
        	$errorMsg[]="Please enter the track ID";
    	} else {
        	$valid = verifyAlphaNum ($pkTrackID); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The track ID must be letters and numbers, spaces, dashes and ' only.";
        	}
    	}
    	
    	$sql = "SELECT pkTrackID FROM tblTrack WHERE pkTrackID='" . $pkTrackID . "'";
    	$myData = mysql_query($sql,$connectID);
    	$exists = mysql_num_rows($myData);
    	if($exists==0){
    		$errorMsg[]="This track does not exist.";
    	}
    	
    	$sql = "SELECT fkCatNum FROM tblReleaseTrack WHERE fkTrackID='" . $pkTrackID . "'";
    	$myData = mysql_query($sql,$connectID);
    	$releaseExists = mysql_num_rows($myData);
    	$release = mysql_fetch_array($myData);
    	$sql = "SELECT fkTrackID FROM tblReleaseTrack WHERE (fkCatNum='" . $release[0] . "' AND fkTrackID!='0')";
    	$myData = mysql_query($sql,$connectID);
    	$totalTracks = mysql_num_rows($myData);
    	
    	if($releaseExists==1 && $totalTracks==1){
			$sql = "DELETE FROM tblRelease WHERE pkCatNum='" . $release[0] . "'";
			$myData = mysql_query($sql,$connectID);
			$sql = "DELETE FROM tblReleaseTrack WHERE (fkCatNum='" . $fkCatNum . "' AND fkTrackID='0')";
			$deleteBadRelation = mysql_query($sql,$connectID);
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
        echo "<p>Deletion successful. Click <a href='/~rcary/cs148/finalproject/browse/'>here</a> to clarify.</p>";
        
        $sql = "DELETE FROM tblTrack WHERE ";
        $sql .= "pkTrackID='" . $pkTrackID . "'";
        $myData = mysql_query($sql,$connectID);
        
        $sql = "DELETE FROM tblReleaseTrack WHERE fkTrackID='" . $pkTrackID . "'";
        $deleteRelation = mysql_query($sql,$connectID);
    }
}
?>
	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmDeleteRelease'
			method='post'
			style='text-align:center'>
        <fieldset>
            <label for="txtTrackID">Track ID*</label><br />
            <input name="txtTrackID" type="text" size="4" id="txtTrackID" <? print 'value="' . $pkTrackID . '"'; ?>/><br /><br />
           
            <input type="submit" name="cmdDeleteSubmit" value="Delete it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>
<?php include("menubar.php"); ?>
</body>
</html>