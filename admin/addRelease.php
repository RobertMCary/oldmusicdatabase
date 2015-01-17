<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Add a release</title>
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
$releaseTitle="";
$label="";
$format="";
$releaseDate="";
$beatLink="";
$numTracks="";
$comments="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $pkCatNum = $_POST["txtCatNum"];
    $releaseTitle = $_POST["txtReleaseTitle"];
    $label = $_POST["txtLabel"];
    $format = $_POST["txtFormat"];
    $releaseDate = $_POST["txtDate"];
    $beatLink = $_POST["txtBeatLink"];
    $numTracks = $_POST["txtNumTracks"];
    $comments = $_POST["txtComments"];
    
    //take care of any html characters including quotes (double and single)
    $pkCatNum = htmlentities($pkCatNum, ENT_QUOTES);
    $releaseTitle = htmlentities($releaseTitle, ENT_QUOTES);
    $label = htmlentities($label, ENT_QUOTES);
    $format = htmlentities($format, ENT_QUOTES);
    $releaseDate = htmlentities($releaseDate, ENT_QUOTES);
    $beatLink = htmlentities($beatLink, ENT_QUOTES);
    $numTracks = htmlentities($numTracks, ENT_QUOTES);
    $comments = htmlentities($comments, ENT_QUOTES);

    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element 
    if($releaseTitle==""){
        $errorMsg[]="Please enter the release title";
    } else {
        $valid = verifyAlphaNum ($releaseTitle); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The release title must be letters and numbers, spaces, dashes and ' only.";
        }
    }
    
    if($pkCatNum==""){
        $errorMsg[]="Please enter the catalog number";
    } else {
        $valid = verifyAlphaNum ($pkCatNum); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The catalog number must be letters and numbers, spaces, dashes and ' only.";
        }
    }

	if($label==""){
        $errorMsg[]="Please enter the label";
    } else {
        $valid = verifyAlphaNum ($label); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The label must be letters and numbers, spaces, dashes and ' only.";
        }
    }
    
    if($format==""){
    	$errorMsg[]="Please enter the format";
    } else {
    	$valid = verifyAlphaNum ($format);
    	if (!$valid){
    		$error_msg[]="Format must be letters and numbers only. See the format area for reference.";
    	}
    }
    
    if($numTracks==""){
    	$errorMsg[]="Please enter the number of tracks";
    } else {
    	$valid = verifyNum ($numTracks);
    	if (!$valid){
    		$error_msg[]="The number of tracks must be numbers and spaces only.";
    	}
    }
    
    if($comments==""){
        $errorMsg[]="Please enter your comments";
    } else {
        $valid = verifyAlphaNum ($comments); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The comments must contain letters and numbers, spaces, dashes and ' only.";
        }
    }
    
    /*
    if($beatLink==""){
    	$errorMsg[]="Please enter the Beatport link";
    } else {
    	$valid = verifyMediaURL ($beatLink);
    	if (!$valid){
    		$error_msg[]="The Beatport link must be an actual Beatport link!";
    	}
    }
    */
    
    $sql = "SELECT pkCatNum FROM tblRelease WHERE pkCatNum='" . $pkCatNum . "'";
    $exists = mysql_query($sql,$connectID);
    $anyRelease = mysql_num_rows($exists);
    if($anyRelease!=0){
    	$errorMsg[]="This release already exists.";
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
        echo "<p>Entry successful. Click <a href='/~rcary/cs148/finalproject/browse/releasePage.php?CatNum=" . $pkCatNum . "'>here</a> to view this release.</p>";
        
        $sql = "INSERT INTO tblRelease SET ";
        $sql .= "pkCatNum='" . $pkCatNum . "', ";
        $sql .= "fldReleaseTitle='" . $releaseTitle . "', ";
        $sql .= "fldLabel='" . $label. "', ";
        $sql .= "fldFormat='" . $format ."', ";
        $sql .= "fldNumTracks='" . $numTracks ."', ";
        $sql .= "fldBeatLink='" . $beatLink ."', ";
        $sql .= "fldComments='" . $comments ."', ";
        $sql .= "fldReleaseDate='" . $releaseDate ."'";
        $myData = mysql_query($sql,$connectID);
        
        $sql = "INSERT INTO tblReleaseTrack SET ";
        $sql .= "fkCatNum='" . $pkCatNum . "'";
        $myData = mysql_query($sql,$connectID);
		
		/*
		$myFilePath="";
        $myFileName="rcarysql.txt";
        $myPointer=fopen($myFilePath.$myFileName, "a+");
        
        if($myPointer){
            print "File Opened";
        }
        
        $sql .= "\n"; // end of line
        
        fputs($myPointer,$sql);
        fclose($myPointer);
        */
        
    }
}
?>
	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmRelease'
			method='post'
			style='text-align:center'>
			
        <fieldset>
            <label for="txtReleaseTitle">Release Title*</label><br />
            <input name="txtReleaseTitle" type="text" size="50" id="txtReleaseTitle" <? print "value='$releaseTitle'"; ?>/><br /><br />
             
            <label for="txtCatNum">Catalog Number*</label><br />
            <input name="txtCatNum" type="text" size="15" id="txtCatNum" <? print 'value="' . $pkCatNum . '"'; ?>/><br /><br />
     
            <label for="txtLabel">Label* (full name please)</label><br />
            <input name="txtLabel" type="text" size="50" id="txtLabel" <? print "value='$label'"; ?> /><br /><br />
     
     		<label for="txtFormat">Format* (12I, 7I, MP3, CD, etc.)</label><br />
     		<input name="txtFormat" type="text" size="3" id="txtFormat" <? print "value='$format'"; ?> /><br /><br />
     		
     		<label for="txtDate">Release Date (YYYY-MM-DD)</label><br />
     		<input name="txtDate" type="text" size="10" id="txtDate" <? print "value='$releaseDate'"; ?> /><br />
     		
     		<label for="txtNumTracks"># of Tracks*</label><br />
            <input name="txtNumTracks" type="text" size="2" id="txtNumTracks" <? print 'value="' . $numTracks . '"'; ?>/><br />
            
            <label for="txtBeatLink">Beatport Link</label><br />
            <input name="txtBeatLink" type="text" size="30" id="txtBeatLink" <? print 'value="' . $beatLink . '"'; ?>/><br />
           
            <label for="txtComments">Comments*</label><br />
            <input name="txtComments" type="text" size="30" id="txtComments" <? print 'value="' . $comments . '"'; ?>/><br />
           
            <input type="submit" name="cmdSubmitted" value="Add it!" /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>

<?php include("menubar.php"); ?>
</body>
</html>