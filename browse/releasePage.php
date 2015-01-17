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
$catNum = $_GET["CatNum"];

$sql = "SELECT * FROM tblRelease WHERE pkCatNum='" . $catNum . "'";
$myData = mysql_query($sql,$connectID);
$record = mysql_fetch_row($myData); //row is an array of every field of that record
$title = "<h1 class='rp1'>" . $record[1] . "</h1>";
echo $title;
$label = "<h2 class='rp2'>" . $record[2] . " / " . $record[0] . "</h2>";
echo $label;

print "<div id='imageBox'><img src='/~rcary/cs148/finalproject/images/" . $catNum . ".jpg' alt='Album cover' height='300' width='300' /></div>";

	print "<div style='top: 10%; height: 350px; width: 50%; float: left; overflow: auto;'>";
	print "<table border='1'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<7;$i++){
        if ($i==0){
        	print "<th>Track Number</th>";
        } else if ($i==1) {
        	print "<th>Producer(s)</th>";
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
	
	$sql = "SELECT fkTrackID FROM tblReleaseTrack WHERE fkCatNum='" . $catNum . "' ORDER BY fkTrackID ASC";
	$myData2 = mysql_query($sql,$connectID);
	$numRows = mysql_num_rows($myData2);
	$sql = "SELECT ";
	
	$j=0;
	while($listTrack = mysql_fetch_array($myData2)){	
		$sql = "SELECT fldTrackNum, fldProducer, fldTrackTitle, fldKey, fldBPM, fldGenre, fldDuration FROM tblTrack WHERE pkTrackID='" . $listTrack[$j] . "'";
    	$trackInfo = mysql_query($sql,$connectID);
    	while($track = mysql_fetch_array($trackInfo)){
        	print "<tr class='tablerow'>";
        	for($i=0; $i<7;$i++){
        		if($i==2){
        			$sql = "SELECT fldYTLink FROM tblTrack WHERE fldTrackTitle='" . $track[2] . "'";
        			$myData = mysql_query($sql,$connectID);
        			$ytLink = mysql_fetch_array($myData);
        			$ytString = "<td><a href='" . $ytLink[0] . "'>" . $track[2] . "</a></td>";
        			print $ytString;
        		} else if($i==1){
        			print "<td><a href='producerPage.php?producer=" . urlencode($track[1]) . "'>" . $track[1] . "</a></td>";
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
<div id="releaseComment">
	<?php
		$sql = "SELECT fldComments FROM tblRelease WHERE pkCatNum='" . $catNum . "'";
		$myData = mysql_query($sql,$connectID);
		$commentText = mysql_fetch_array($myData);
		$comment = "<p style='font-weight: bold; font-style: italic;'>Nightowl's Thoughts:</p><p>" . $commentText[0] . "</p>";
		print $comment;
	?>
</div>
</body>
</html>