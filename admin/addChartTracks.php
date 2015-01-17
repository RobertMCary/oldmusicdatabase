<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Add tracks to a chart</title>
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
$chartID="";
$trackID="";

if(isset($_POST["cmdSubmitted"])){

	$chartID=$_POST["txtChartID"];
	$trackID=$_POST["txtTrackID"];

	$chartID = htmlentities($chartID, ENT_QUOTES);
	$trackID = htmlentities($trackID, ENT_QUOTES);

	include ("validation_functions.php");
	$errorMsg=array();
	
	if($chartID==""){
        $errorMsg[]="Please enter the chart ID";
    } else {
        $valid = verifyNum ($chartID); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="Chart ID must be numbers only.";
        }
    }
    
    if($trackID==""){
        $errorMsg[]="Please enter the track ID";
    } else {
        $valid = verifyNum ($trackID); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="Track ID must be numbers only.";
        }
    }
    
    $sql = "SELECT pkChartID FROM tblChart WHERE pkChartID='" . $chartID . "'";
    $myData = mysql_query($sql,$connectID);
    $exists = mysql_num_rows($myData);
    if($exists==0){
    	$errorMsg[]="This chart does not exist!";
    }
    
    $sql = "SELECT fldNumTracks FROM tblChart WHERE pkChartID='" . $chartID . "'";
    $myData = mysql_query($sql,$connectID);
    $array = mysql_fetch_array($myData);
    $totalTracks = $array[0];
    $sql = "SELECT fkTrackID FROM tblChartTrack WHERE fkChartID='" . $chartID . "' AND fkTrackID!='0'";
    $myData = mysql_query($sql,$connectID);
    $numTracks = mysql_num_rows($myData);
    if($numTracks==$totalTracks){
    	$errorMsg[]="This chart is full! Either remove a track from this chart or create another.";	
    }
    
    if($errorMsg){
        echo "<ul>\n";
        foreach($errorMsg as $err){
            echo "<li style='color: #ff6666'>" . $err . "</li>\n";
        }
        echo "</ul>\n";
    } else {
		echo "<p>Entry successful. Click <a href='/~rcary/cs148/finalproject/browse/chartPage.php?ChartID=" . $chartID . "'>here</a> to view your addition.</p>";
        
        $sql = "INSERT INTO tblChartTrack SET fkTrackID='" . $trackID . "', fkChartID='" . $chartID . "'";
        $myData = mysql_query($sql,$connectID);
    }
}
?>
<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmChrtTrcks'
			method='post'
			style='text-align:center'>
			
        <fieldset>
            <label for="txtChartID">Chart ID*</label><br />
            <input name="txtChartID" type="text" size="3" id="txtChartID" <? print 'value="' . $chartID . '"'; ?>/><br /><br />
            
            <label for="txtTrackID">Track ID to add*</label><br />
            <input name="txtTrackID" type="text" size="4" id="txtTrackID" <? print 'value="' . $trackID . '"'; ?>/><br /><br />
           
            <input type="submit" name="cmdSubmitted" value="Add it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>
<?php include("menubar.php"); ?>
</body>
</html>