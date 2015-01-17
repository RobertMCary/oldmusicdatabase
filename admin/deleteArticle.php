<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Delete an article</title>
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
$articleID="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $articleID = $_POST["txtArticleID"];
    
    //take care of any html characters including quotes (double and single)
    $articleID = htmlentities($articleID, ENT_QUOTES);
    
    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element 
    
    if($articleID==""){
        $errorMsg[]="Please enter the article ID";
    } else {
        $valid = verifyNum ($articleID); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="Article ID must be numbers only.";
        }
    }
    
    $sql = "SELECT pkArticleID FROM tblArticle WHERE pkArticleID='" . $articleID . "'";
    $myData = mysql_query($sql,$connectID);
    $exists = mysql_num_rows($myData);
    if($exists==0){
    	$errorMsg[]="This article doesn't exist!";
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
        echo "<p>Deletion successful. Click <a href='/~rcary/cs148/finalproject/articles/'>here</a> to clarify.</p>";
        
        $sql = "DELETE FROM tblArticle WHERE pkArticleID='" . $articleID . "'"; 
        $myData = mysql_query($sql,$connectID);
    }
}
?>

	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmDeleteArticle'
			method='post'
			style='text-align:center'>
			
        <fieldset>
            <label for="txtArticleID">Article ID*</label><br />
            <input name="txtArticleID" type="text" size="3" id="txtArticleID" <? print "value='$articleID'"; ?>/><br /><br />
           
            <input type="submit" name="cmdSubmitted" value="Delete it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." /><br /><br />
        </fieldset>
	</form>
</div>

<?php include("menubar.php"); ?>
</body>
</html>