<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Add a chart</title>
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
$chartTitle="";
$comments="";
$numTracks="";
$today="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $chartTitle = $_POST["txtChartTitle"];
    $comments = $_POST["txtComments"];
    $numTracks = $_POST["txtNumTracks"];
    
    //take care of any html characters including quotes (double and single)
    $chartTitle = htmlentities($chartTitle, ENT_QUOTES);
    $comments = htmlentities($comments, ENT_QUOTES);
    $numTracks = htmlentities($numTracks, ENT_QUOTES);
    
    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element 
    if($chartTitle==""){
        $errorMsg[]="Please enter the chart title";
    } else {
        $valid = verifyAlphaNum ($chartTitle); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The chart title must be letters and numbers, spaces, dashes and ' only.";
        }
    }
    
    if($numTracks==""){
        $errorMsg[]="Please enter the number of tracks in the chart";
    } else {
        $valid = verifyNum ($numTracks); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="Number of tracks must be numbers only.";
        }
    }
    
    $sql = "SELECT pkChartID FROM tblChart WHERE fldChartTitle='" . $chartTitle . "'";
    $myData = mysql_query($sql,$connectID);
    $exists = mysql_num_rows($myData);
    if($exists!=0){
    	$errorMsg[]="This chart title is taken!";
    }
    
    if($numTracks>10){
    	$errorMsg[]="Too many tracks! Ten maximum.";
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
        echo "<p>Entry successful. Click <a href='/~rcary/cs148/finalproject/browse/'>here</a> to see the chart.</p>";
        $today = date("Y-m-d");
        
        $sql = "INSERT INTO tblChart SET ";
        $sql .= "fldChartTitle='" . $chartTitle . "', ";
    	$sql .= "fldComments='" . $comments . "', ";
    	$sql .= "fldNumTracks='" . $numTracks . "', ";
        $sql .= "fldDate='" . $today ."'";
        $myData = mysql_query($sql,$connectID);
        
        $sql = "SELECT pkChartID FROM tblChart WHERE fldChartTitle='" . $chartTitle . "'";
        $myData = mysql_query($sql,$connectID);
        $chartID = mysql_fetch_array($myData);
        
        $sql = "INSERT INTO tblChartTrack SET fkChartID='" . $chartID[0] . "'";
        $createRelation = mysql_query($sql,$connectID);
    }
}
?>

	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmChart'
			method='post'
			style='text-align:center'>
			
        <fieldset>
            <label for="txtChartTitle">Chart Title*</label><br />
            <input name="txtChartTitle" type="text" size="50" id="txtChartTitle" <? print "value='$chartTitle'"; ?>/><br /><br />
     		
     		<label for="txtComments">Comments</label><br />
     		<input name="txtComments" type="text" size="20" id="txtComments" <? "value='$comments'"; ?>/><br /><br />
     		
     		<label for="txtNumTracks"># of Tracks* (10 max)</label><br />
            <input name="txtNumTracks" type="text" size="2" id="txtNumTracks" onchange="chartTracks(' . <?php echo $numTracks;?> . ')" <? print 'value="' . $numTracks . '"'; ?>/><br /><br />
           
            <input type="submit" name="cmdSubmitted" value="Add it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." /><br /><br />
        </fieldset>
	</form>
</div>

<?php include("menubar.php"); ?>
</body>
</html>