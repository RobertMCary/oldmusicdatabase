<?php
include("/usr/local/uvm-inc/rcary.inc");
include("connect.inc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Browse</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Rob Cary" />
<meta name="description" content="The internet home of DJ Nightowl" />

<link rel="stylesheet" href="/~rcary/cs148/finalproject/ss/NOdefault.css" type="text/css" title="nighttime" media="screen" />
<link rel="alternate stylesheet" href="/~rcary/cs148/finalproject/ss/NOdaytime.css" type="text/css" title="daytime" media="screen" />
<link rel="alternate stylesheet" href="/~rcary/cs148/finalproject/ss/NOtropical.css" type="text/css" title="tropical" media="screen" />
<link rel="alternate stylesheet" href="/~rcary/cs148/finalproject/ss/NOdarkness.css" type="text/css" title="darkness" media="screen" />

<script src="cookies.js" type="text/javascript"></script>

<script src="/~rcary/cs148/finalproject/styleCheck.js" type="text/javascript"></script>

<script type="text/javascript">
//<![CDATA[
	function runHelp(){
		alert("Welcome to the browse page. You can check the bottom right hand corner of the page for options on how you'd like to browse the music here. On tracks, clicking on the name of a track should re-direct you to a YouTube clip of the song. On releases, clicking on a release's catalog number will direct you to the release page featuring info on all of a releases tracks (the ones in our databases, that is). On charts, the process is equatable to browsing releases. Enjoy!");
	}
//]]>
</script>		
<script type="text/javascript">
//<![CDATA[
function browseDisplay(){
	if(document.getElementById("optRelease").checked==true){
		document.getElementById("releaseTable").style.display="block";
		document.getElementById("trackTable").style.display="none";
		document.getElementById("chartTable").style.display="none";
	} else if(document.getElementById("optTrack").checked==true){
		document.getElementById("releaseTable").style.display="none";
		document.getElementById("trackTable").style.display="block";
		document.getElementById("chartTable").style.display="none";
	} else if(document.getElementById("optChart").checked==true){
		document.getElementById("chartTable").style.display="block";
		document.getElementById("releaseTable").style.display="none";
		document.getElementById("trackTable").style.display="none";
	}
}
//]]>
</script>
</head>

<body>
<h1>BROWSE</h1>
<div id='helpBox'>
	<input type="button" value="Help" onclick="runHelp()" />
</div>
<?
	
	//border:3px solid #F3E2A9;
	print "<div style='height: 400px; width: 75%; float: left; overflow: auto; text-align: center;'>";
	//*******************************************RELEASE TABLE
	$sql = "SHOW COLUMNS FROM tblRelease";
	$release = mysql_query($sql,$connectID);
	$span = mysql_num_rows($release);
	
	print "<table id='releaseTable' class='tableclass' border='0'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<8;$i++){
        if ($i==0){
        	print "<th>Catalog Number</th>";
        } else if ($i==1) {
        	print "<th>Release Title</th>";
        } else if ($i==2) {
        	print "<th>Label</th>";
        } else if ($i==3) {
        	print "<th>Format</th>";
        } else if ($i==4) {
        	print "<th>Release Date</th>";
        } else if ($i==5) {
        	print "<th>Beatport Link</th>";
        } else if ($i==6) {
        	print "<th># of Tracks</th>";
        } else if ($i==7) {
        	print "<th>Album Art</th>";
        }
        $columns++;
    }
    print "</tr></thead>";
    
    //now print out each record
    //$sql = $_POST["lstSort"];
    $sql = "SELECT * FROM tblRelease ORDER BY pkCatNum ASC";
    $info2 = mysql_query($sql,$connectID);
    while($rec = mysql_fetch_array($info2)){
        print "<tr class='tablerow'>";
        for($i=0; $i<$columns;$i++){
        	if ($i==0){
        		$releasePage = "<td class='tabledata'><a href='releasePage.php?CatNum=" . $rec[$i] . "'>" . $rec[$i] . "</a></td>";
        		print $releasePage;
        	} else if ($i==7){
        		$albumArt = "<td class='tabledata'><img src='/~rcary/cs148/finalproject/images/" . $rec[0] . ".jpg' alt='dis image' height='150' width='150' /></td>";
        		print $albumArt;
        	} else if ($i==1){
        		$changeTitle = "<td class='tabledata' style='font-weight: 90%; font-style: italic; font-size: 110%;'>" . $rec[$i] . "</td>";
        		print $changeTitle;
        	} else if ($i==5){
        		$btLink = "<td class='tabledata'><a href='" . $rec[$i] . "'>Beatport</a></td>";
        		print $btLink;
        	} else if ($i==6){
        		$sql = "SELECT fkTrackID FROM tblReleaseTrack WHERE (fkCatNum='" . $rec[0] . "' AND fkTrackID!='0')";
        		$myData = mysql_query($sql,$connectID);
        		$numTracks = mysql_num_rows($myData);
        		$track = "<td class='tabledata'>" . $numTracks . "/" . $rec[6] . "</td>";
        		print $track;
        	} else {
            	print "<td class='tabledata'>" . $rec[$i]  . "</td>";
            }
        }
        print "</tr>";
    }
    
    // all done
    print "</table>";
    
    
    

    //*******************************************TRACK TABLE
    $sql = "SHOW COLUMNS FROM tblTrack";
	$release = mysql_query($sql,$connectID);
	$span = mysql_num_rows($release);
	
	print "<table id='trackTable' class='tableclass' border='0'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<7;$i++){
        if ($i==0){
        	print "<th>Track ID</th>";
        } else if ($i==1) {
        	print "<th>Producer</th>";
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
    
    //now print out each record
    $sql = "SELECT pkTrackID, fldProducer, fldTrackTitle, fldKey, fldBPM, fldGenre, fldDuration FROM tblTrack ORDER BY pkTrackID ASC";
    $info2 = mysql_query($sql,$connectID);
    while($track = mysql_fetch_array($info2)){
        print "<tr class='tablerow'>";
        for($i=0; $i<$columns;$i++){
        	if($i==2){
        		$sql2 = "SELECT fldYTLink FROM tblTrack WHERE pkTrackID='" . $track[0] . "'";
        		$myData = mysql_query($sql2,$connectID);
        		$exists = mysql_num_rows($myData);
        		$ytLink = mysql_fetch_array($myData);
        		if($exists!=0){
        			$yt = "<td class='tabledata'><a href='" . $ytLink[0] . "'>" . $track[$i] . "</a></td>";
        			print $yt;
        		} else if($ytLink[0]==null){
        			$yt = "td class='tabledata'>" . $track[$i] . "</td>";
        			print $yt;
        		}
        	} else if($i==1){
        		print "<td class='tabledata'><a href='producerPage.php?producer=" . urlencode($track[$i]) . "'>" . $track[$i] . "</a></td>";
        	} else {
            	print "<td class='tabledata'>" . $track[$i]  . "</td>";
            }
        }
        print "</tr>";
    }
    
    // all done
    print "</table>";
    
    
    
    //*******************************************CHART TABLE
    $sql = "SHOW COLUMNS FROM tblChart";
	$chart = mysql_query($sql,$connectID);
	$span = mysql_num_rows($chart);
	
	print "<table id='chartTable' class='tableclass' border='0'>";
	
	//print out column headings
	print "<thead class='tableheader'><tr>";
	$columns=0;
    for ($i=0;$i<5;$i++){
        if ($i==0){
        	print "<th>Chart ID</th>";
        } else if ($i==1) {
        	print "<th>Chart Title</th>";
        } else if ($i==2) {
        	print "<th>Date</th>";
        } else if ($i==3) {
        	print "<th>Comments</th>";
        } else if ($i==4) {
        	print "<th>Number of Tracks</th>";
        }
        $columns++;
    }
    print "</tr></thead>";
    
    //now print out each record
    $sql = "SELECT * FROM tblChart ORDER BY pkChartID ASC";
    $info2 = mysql_query($sql,$connectID);
    while($chart = mysql_fetch_array($info2)){
        print "<tr class='tablerow'>";
        for($i=0; $i<$columns;$i++){
            if ($i==0){
        		$chartPage = "<td class='tabledata'><a href='chartPage.php?ChartID=" . $chart[$i] . "'>" . $chart[$i] . "</a></td>";
        		print $chartPage;
        	} else if($i==3){
        		print "<td class='tabledata'>(See inside)</td>";
        	} else {
            	print "<td class='tabledata'>" . $chart[$i]  . "</td>";
            }
        }
        print "</tr>";
    }
    
    // all done
    print "</table>";  
    print "</div>";
?>
<div id="browseBar">
	<h2>Browse by:</h2>
	<form id="browseBox" action="">
		<fieldset>
			<ul>
			<li><label><input type="radio" id="optTrack" name="optBrowse" value="Tracks" onclick="javascript:browseDisplay();" />Tracks</label></li>
			<li><label><input type="radio" id="optRelease" name="optBrowse" value="Releases" onclick="javascript:browseDisplay();" checked="checked" />Releases</label></li>
			<li><label><input type="radio" id="optChart" name="optBrowse" value="Charts" onclick="javascript:browseDisplay();" />Charts</label></li>
			</ul>
		</fieldset>
	</form>
</div>

<!--
<div id="rSearchBox">
	<h2>Sort by:</h2>
	<form method="post" id="rSearchBoxForm" action="">
		<fieldset>
			<select id="lstSort" size="1"> 
			<option value="SELECT pkCatNum, fldReleaseTitle, fldLabel, fldFormat, fldReleaseDate, fldBeatLink, fldNumTracks, fldAlbumArt, fldComments FROM tblRelease ORDER BY pkCatNum ASC" selected="selected">Catalog number</option>
			<option value="SELECT pkCatNum, fldReleaseTitle, fldLabel, fldFormat, fldReleaseDate, fldBeatLink, fldNumTracks, fldAlbumArt, fldComments FROM tblRelease ORDER BY fldReleaseTitle ASC">Release title</option>
			<option value="SELECT pkCatNum, fldReleaseTitle, fldLabel, fldFormat, fldReleaseDate, fldBeatLink, fldNumTracks, fldAlbumArt, fldComments FROM tblRelease ORDER BY fldLabel ASC">Label</option>
			<option value="SELECT pkCatNum, fldReleaseTitle, fldLabel, fldFormat, fldReleaseDate, fldBeatLink, fldNumTracks, fldAlbumArt, fldComments FROM tblRelease ORDER BY fldFormat ASC">Format</option>
			<option value="SELECT pkCatNum, fldReleaseTitle, fldLabel, fldFormat, fldReleaseDate, fldBeatLink, fldNumTracks, fldAlbumArt, fldComments FROM tblRelease ORDER BY fldReleaseDate ASC">Release date</option>
			<option value="SELECT pkCatNum, fldReleaseTitle, fldLabel, fldFormat, fldReleaseDate, fldBeatLink, fldNumTracks, fldAlbumArt, fldComments FROM tblRelease ORDER BY fldNumTracks ASC"># of tracks</option>
			</select>
		</fieldset>
	</form>
</div>-->

<?php include("menubar.php"); ?>
</body>
</html>