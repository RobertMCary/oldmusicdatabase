<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>NIGHTOWL: Administrative page</title>
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
<p>
	What do you want to do? <br /><br />
		<input type="button" name="addRelease" onclick="window.location.href='addRelease.php'" value="Add a release" />
		<br /><br />
		<input type="button" name="updateRelease" onclick="window.location.href='updateRelease.php'" value="Update a release" />
		<br /><br />
		<input type="button" name="deleteRelease" onclick="window.location.href='deleteRelease.php'" value="Delete a release" />
		<br /><br />
		<input type="button" name="addTracks" onclick="window.location.href='tracksForm.php'" value="Add tracks to a pre-existing release" />
		<br /><br />
		<input type="button" name="updateTrack" onclick="window.location.href='updateTrack.php'" value="Update a track" />
		<br /><br />
		<input type="button" name="deleteTrack" onclick="window.location.href='deleteTrack.php'" value="Delete a track" />
		<br /><br />
		<input type="button" name="addChart" onclick="window.location.href='addChart.php'" value="Add a chart" />
		<br /><br />
		<input type="button" name="addChartTracks" onclick="window.location.href='addChartTracks.php'" value="Add tracks to a pre-existing chart" />
		<br /><br />
		<input type="button" name="deleteChart" onclick="window.location.href='deleteChart.php'" value="Delete a chart" />
		<br /><br />
		<input type="button" name="addArticle" onclick="window.location.href='addArticle.php'" value="Add an article" />
		<br /><br />
		<input type="button" name="deleteArticle" onclick="window.location.href='deleteArticle.php'" value="Delete an article" />
</p>

<?php include("menubar.php"); ?>
</body>
</html>