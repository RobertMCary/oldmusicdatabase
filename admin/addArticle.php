<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Add an article</title>
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
<h2>*NOTE: Articles are uploaded separately, this form simply adds access to the article through use of the database.</h2>
<div id="browsemenu">
	
<?php
$fldArticleTitle="";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
// if form has been submitted, validate the information
if (isset($_POST["cmdSubmitted"])){
    // initialize my variables to the forms posting    
    $fldArticleTitle = $_POST["txtArticleTitle"];
    
    //take care of any html characters including quotes (double and single)
    $fldArticleTitle = htmlentities($fldArticleTitle, ENT_QUOTES);

    include ("validation_functions.php");
    $errorMsg=array();
    
    //%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
	// begin testing each form element 
    if($fldArticleTitle==""){
        $errorMsg[]="Please enter the article title";
    } else {
        $valid = verifyAlphaNum ($fldArticleTitle); /* test for non-valid  data */
        if (!$valid){ 
            $error_msg[]="The article title must be letters and numbers, spaces, dashes and ' only.";
        }
    }
    
    $sql = "SELECT fldArticleTitle FROM tblArticle WHERE fldArticleTitle='" . $fldArticleTitle . "'";
    $exists = mysql_query($sql,$connectID);
    $anyArticle = mysql_num_rows($exists);
    if($anyArticle!=0){
    	$errorMsg[]="This article title already exists.";
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
        echo "<p>Entry successful. Click <a href='/~rcary/cs148/finalproject/articles/'>here</a> to see the article.</p>";
        $now = date("Y-m-d");
        
        $sql = "INSERT INTO tblArticle SET ";
        $sql .= "fldArticleTitle='" . $fldArticleTitle . "', ";
        $sql .= "fldDate='" . $now . "'";

        $myData = mysql_query($sql,$connectID);   
    }
}
?>
	<form action="<? print $_SERVER['PHP_SELF']; ?>"
			id='frmArticle'
			method='post'
			style='text-align:center'>
			
        <fieldset>
            <label for="txtArticleTitle">Article Title*</label><br />
            <input name="txtArticleTitle" type="text" size="50" id="txtArticleTitle" <? print "value='$fldArticleTitle'"; ?>/><br /><br />
           
            <input type="submit" name="cmdSubmitted" value="Add it!" /><br /><br />
            <input type="reset" name="cmdReset" value="Reset form." />
        </fieldset>
	</form>
</div>
<?php include("menubar.php"); ?>
</body>
</html>