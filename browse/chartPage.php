<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Nightowl: Chart View</title>
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
$chartID = $_GET["ChartID"];

$sql = "SELECT * FROM tblChart WHERE pkChartID='" . $chartID . "'";
$myData = mysql_query($sql,$connectID);
$chartInfo = mysql_fetch_row($myData);
$title = "<h1 class='rp1'>" . $chartInfo[1] . "</h1>";
echo $title;
$date = "<h2 class='rp2'>" . $chartInfo[2] . "</h2>";
echo $date;
$comments = "<div id='commentsBox'>" . $chartInfo[3] . "</div>";
echo $comments;

	
	print "<div style='top: 10%; height: 350px; width: 50%; float: center; overflow: auto;'>";
	print "<table border='1'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<5;$i++){
        if ($i==0){
        	print "<th></th>";
        } else if ($i==1) {
        	print "<th>Producer</th>";
        } else if ($i==2) {
        	print "<th>Track Title</th>";
        } else if ($i==3) {
        	print "<th>Genre</th>";
        } else if ($i==4) {
        	print "<th>Duration</th>";        	
        }
        $columns++;
    }
    print "</tr></thead>";
	
	$sql = "SELECT fkTrackID FROM tblChartTrack WHERE fkChartID='" . $chartID . "' ORDER BY fkTrackID ASC";
	$myData2 = mysql_query($sql,$connectID);
	$numRows = mysql_num_rows($myData2);
	
	$j=0;
	$count=0;
	while($listTrack = mysql_fetch_array($myData2)){
		$sql = "SELECT fldProducer, fldTrackTitle, fldGenre, fldDuration FROM tblTrack WHERE pkTrackID='" . $listTrack[$j] . "' ORDER BY fldTrackNum ASC";
    	$trackInfo = mysql_query($sql,$connectID);
    	while($track = mysql_fetch_array($trackInfo)){
        	print "<tr class='tablerow'>";
        	for($i=0; $i<5;$i++){
        		if($i==0){
        			$count++;
        			print "<td>" . $count . "</td>";
        		} else if($i==2) {
        			$sql = "SELECT fldYTLink FROM tblTrack WHERE fldTrackTitle='" . $track[1] . "'";
        			$myData = mysql_query($sql,$connectID);
        			$ytLink = mysql_fetch_array($myData);
        			print "<td><a href='". $ytLink[0] . "'>" . $track[1] . "</a></td>";
        		} else if($i==1){ 
            		print "<td><a href='producerPage.php?producer=" . urlencode($track[0]) . "'>" . $track[0] . "</a></td>";
            	} else {
            		print "<td>" . $track[$i-1]  . "</td>";
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