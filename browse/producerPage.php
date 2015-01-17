<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Release View</title>
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
<?php
$producer = $_GET["producer"];

//$sql = "SELECT * FROM tblTrack WHERE fldProducer='" . $producer . "'";
echo "<h1 class='rp1'>" . $producer . "</h1>";

	print "<div style='top: 10%; height: 400px; width: 50%; float: left; overflow: auto;'>";
	print "<table border='1'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<7;$i++){
        if ($i==0){
        	print "<th>Track ID</th>";
        } else if ($i==1) {
        	print "<th>Release Title</th>";
        } else if ($i==2) {
        	print "<th>Track Title</th>";
        } else if ($i==3) {
        	print "<th>Key</th>";
        } else if ($i==4) {
        	print "<th>BPM</th>";
        } else if ($i==5) {
        	print "<th>Genre</th>";
        } else if ($i==6) {
        	print "<th>Duration</th>";
        }
        $columns++;
    }
    print "</tr></thead>";
	
	$sql = "SELECT fldProducer FROM tblTrack WHERE fldProducer='" . $producer . "' LIMIT 1";
	$myData2 = mysql_query($sql,$connectID);
	$numRows = mysql_num_rows($myData2);
	
	$j=0;
	while($listTrack = mysql_fetch_array($myData2)){	
		$sql = "SELECT pkTrackID, fldTrackTitle, fldKey, fldBPM, fldGenre, fldDuration FROM tblTrack WHERE fldProducer='" . $listTrack[$j] . "'";
    	$trackInfo = mysql_query($sql,$connectID);
    	while($track = mysql_fetch_array($trackInfo)){
        	print "<tr class='tablerow'>";
        	for($i=0; $i<7;$i++){
        		if($i==2){
        			$sql = "SELECT fldYTLink FROM tblTrack WHERE fldTrackTitle='" . $track[$i-1] . "'";
        			$myData = mysql_query($sql,$connectID);
        			$ytLink = mysql_fetch_array($myData);
        			$ytString = "<td><a href='" . $ytLink[0] . "'>" . $track[$i-1] . "</a></td>";
        			print $ytString;
        		} else if($i==1){
        			$sql = "SELECT fkCatNum FROM tblReleaseTrack WHERE fkTrackID='" . $track[0] . "'";
        			$myData = mysql_query($sql,$connectID);
        			$catNum = mysql_fetch_array($myData);
        			$sql = "SELECT fldReleaseTitle FROM tblRelease WHERE pkCatNum='" . $catNum[0] . "'";
        			$myData = mysql_query($sql,$connectID);
        			$releaseTitle = mysql_fetch_array($myData);
        			print "<td><a href='releasePage.php?CatNum=" . $catNum[0] . "'>" . $releaseTitle[0] . "</a></td>";
        		} else if($i>1){
            		print "<td>" . $track[$i-1]  . "</td>";
        		} else {
        			print "<td>" . $track[$i]  . "</td>";
        		}
        	}
        	print "</tr>";
    	}
    	
    }	
    // all done
    print "</table>";
    print "</div>";
?>
<?php include("menubar.php"); ?>
</body>
</html>