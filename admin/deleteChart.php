<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Delete a chart</title>
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

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $chartID = $_POST["txtChartID"];
    
    //take care of any html characters including quotes (double and single)
    $chartID = htmlentities($chartID, ENT_QUOTES);
    
    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element 
    
    if($chartID==""){
        $errorMsg[]="Please enter the chart ID";
    } else {
        $valid = verifyNum ($chartID); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="Chart ID must be numbers only.";
        }
    }
    
    $sql = "SELECT pkChartID FROM tblChart WHERE pkChartID='" . $chartID . "'";
    $myData = mysql_query($sql,$connectID);
    $exists = mysql_num_rows($myData);
    if($exists==0){
    	$errorMsg[]="This chart doesn't exist!";
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
        
        $sql = "DELETE FROM tblChart WHERE pkChartID='" . $chartID . "'"; 
        $myData = mysql_query($sql,$connectID);
        
        $sql = "DELETE FROM tblChartTrack WHERE fkChartID='" . $chartID . "'";
        $deleteRelation = mysql_query($sql,$connectID);
    }
}
?>

	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmDeleteChart'
			method='post'
			style='text-align:center'>
			
        <fieldset>
            <label for="txtChartID">Chart ID*</label><br />
            <input name="txtChartID" type="text" size="3" id="txtChartID" <? print "value='$chartID'"; ?>/><br /><br />
           
            <input type="submit" name="cmdSubmitted" value="Delete it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." /><br /><br />
        </fieldset>
	</form>
</div>

<?php include("menubar.php"); ?>
</body>
</html>