<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Delete a release</title>
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
$pkCatNum="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdDeleteSubmit"])){
    // initialize my variables to the forms posting    
    $pkCatNum = $_POST["txtCatNum"];
    //take care of any html characters including quotes (double and single)
    $pkCatNum = htmlentities($pkCatNum, ENT_QUOTES);
    include ("validation_functions.php");
    $errorMsg=array();
    
    	if($pkCatNum==""){
        	$errorMsg[]="Please enter the catalog number";
    	} else {
        	$valid = verifyAlphaNum ($pkCatNum); /* test for non-valid  data */
        	if (!$valid){ 
            	$error_msg[]="The catalog number must be letters and numbers, spaces, dashes and ' only.";
        	}
    	}
    	
    	$sql = "SELECT pkCatNum FROM tblRelease WHERE pkCatNum='" . $pkCatNum . "'";
    	$myData = mysql_query($sql,$connectID);
    	$releaseExist = mysql_num_rows($myData);
    	if($releaseExist==0){
    		$errorMsg[]="This release does not exist.";
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
        
        $sql = "DELETE FROM tblRelease WHERE ";
        $sql .= "pkCatNum='" . $pkCatNum . "'";
        $myData = mysql_query($sql,$connectID);
        
        $sql = "SELECT fkTrackID FROM tblReleaseTrack WHERE fkCatNum='" . $pkCatNum . "'";
        $myData = mysql_query($sql,$connectID);
        $span = mysql_num_rows($myData);
        while($tracks = mysql_fetch_array($myData)){
        	for($g=0;$g<$span;$g++){
        		$sql = "DELETE FROM tblTrack WHERE pkTrackID='" . $tracks[$g] . "'";
        		$delete = mysql_query($sql,$connectID);
        		$sql = "DELETE FROM tblChartTrack WHERE fkTrackID='" . $tracks[$g] . "'";
        		$deleteChartRelation = mysql_query($sql,$connectID);
        	}
        }
        
        $sql = "DELETE FROM tblReleaseTrack WHERE fkCatNum='" . $pkCatNum . "'";
        $deleteRelation = mysql_query($sql,$connectID);
    }
}
?>
	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmDeleteRelease'
			method='post'
			style='text-align:center'>
        <fieldset>
            <label for="txtCatNum">Catalog Number*</label><br />
            <input name="txtCatNum" type="text" size="15" id="txtCatNum" <? print 'value="' . $pkCatNum . '"'; ?>/><br /><br />
           
            <input type="submit" name="cmdDeleteSubmit" value="Delete it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>
<?php include("menubar.php"); ?>
</body>
</html>