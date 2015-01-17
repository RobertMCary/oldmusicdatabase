<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Articles home</title>
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
<h1>Articles</h1>
<?
	print "<div style='height: 350px; float: center; overflow: auto; text-align: center;'>";
	//*******************************************ARTICLE TABLE
	$sql = "SHOW COLUMNS FROM tblArticle";
	$article = mysql_query($sql,$connectID);
	$span = mysql_num_rows($article);
	
	print "<table id='articleTable' class='tableclass' border='0' style='display: block;'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<$span;$i++){
        if ($i==0){
        	print "<th>Article ID</th>";
        } else if ($i==1){
        	print "<th>Date Written</th>";
        } else if ($i==2){
        	print "<th>Article Title</th>";
        }
        $columns++;
    }
    print "</tr></thead>";
    
    //now print out each record
    $sql = "SELECT * FROM tblArticle ORDER BY fldDate ASC";
    $info2 = mysql_query($sql,$connectID);
    while($article = mysql_fetch_array($info2)){
        print "<tr class='tablerow'>";
        for($i=0; $i<$columns;$i++){
        	if($i==2){
        		$sql2 = "SELECT pkArticleID FROM tblArticle WHERE fldArticleTitle='" . $article[2] . "'";
        		$myData = mysql_query($sql2,$connectID);
        		$id = mysql_fetch_array($myData);
        		$articleTitle = "<td class='tabledata'><a href='a" . $id[0] . ".php'>" . $article[2] . "</a></td>";
        		print $articleTitle;
            } else {	
            	print "<td class='tabledata'>" . $article[$i]  . "</td>";
            }
        }
        print "</tr>";
    }
    
    // all done
    print "</table>";
    print "</div>";
?>
<?php include("menubar.php"); ?>
</body>
</html>