<!DOCTYPE html>
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="gw-style.css">
<TITLE>What Dropped?</TITLE>
</HEAD>
<BODY>
<?php
session_start();
include_once 'gw-connect.php';
$con = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
$toonid = $_SESSION['playerid'];
$profcolor = $_SESSION['profcolor'];
$location = mysqli_real_escape_string($con, $_POST['locationid']);
$whatdropped = mysqli_real_escape_string($con, $_POST['gwdrop']);
if ($con->connect_errno > 0){
	die ('Unable to connect to database [' . $db->connect_errno . ']');
}
echo '<STYLE TYPE="TEXT/CSS" MEDIA="SCREEN">body { background-color: ' . $profcolor . '; }</STYLE>';
echo '<CENTER>At ';
$sqlmaplocation = "SELECT * FROM `treasuredata` WHERE `treasureid` = $location";
if (!$result = $con->query($sqlmaplocation)){
	die ('There was an error running the query [' . $con->error . ']');
}
while ($row = $result->fetch_array()){
	$locname = $row['location'];
	$loclink = $row['wikilink'];
	$locid = $row['treasureid'];
	echo '<A HREF="' . $loclink . '" CLASS="navlink">' . $locname . '</A> (Guild Wars Wiki link)';
}
echo '</CENTER>';
if ($whatdropped == "1"){
	echo '<CENTER><FORM METHOD="POST" ACTION="gw-insert.php">';
	echo 'on <INPUT NAME="treasuredate" TYPE="DATE" PLACEHOLDER="2006-10-26"> a ';
	//code for white blue purple etc
	$sqlweaprare = "SELECT * FROM `listrarity` ORDER BY `rareid` ASC";
	if (!$result = $con->query($sqlweaprare)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo '<SELECT NAME="rare">';
	while ($row = $result->fetch_array()){
		$rareid = $row['rareid'];
		$rarity = $row['rarity'];
		echo '<OPTION VALUE="' . $rareid . '">' . $rarity . '</OPTION>';
	}
	echo '</SELECT>, ';
	//code for weapon attribute requirment
	$sqlweapreq = "SELECT * FROM `listreq` ORDER BY `req` ASC";
	if (!$result = $con->query($sqlweapreq)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo 'req<SELECT NAME="requirement">';
	while ($row = $result->fetch_array()){
		$reqid = $row['req'];
		echo '<OPTION VALUE="' . $reqid . '">' . $reqid . '</OPTION>';
	}
	echo '</SELECT>';
	//code for what attribute the weapon is (command, axe mastery, energy storage, etc
	$sqlweapattr = "SELECT * FROM `listattribute` ORDER BY `weapattrid` ASC";
	if (!$result = $con->query($sqlweapattr)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo '<SELECT NAME="attribute">';
	while ($row = $result->fetch_array()){
		$attrid = $row['weapattrid'];
		$weapattr = $row['weaponattribute'];
		echo '<OPTION VALUE="' . $attrid . '">' . $weapattr . '</OPTION>';
	//need to add a nested while loop, to preselect the weapon with the attribute, or somehow java it? An r9 Axe of Energy Storage combo doesn't exist.
	}
	echo '</SELECT>';
	//code for what the weapon is - staff, dagger, scythe, wand, sword, etc
	$sqlweaptype = "SELECT * FROM `listtype` ORDER BY `weaponid` ASC";
	if (!$result = $con->query($sqlweaptype)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo '<SELECT NAME="weapon">';
	while ($row = $result->fetch_array()){
		$typeid = $row['weaponid'];
		$weapon = $row['weapontype'];
		echo '<OPTION VALUE="' . $typeid . '">' . $weapon . '</OPTION>';
	}
	echo '</SELECT> called the <INPUT TYPE="TEXT" NAME="itemname" MAXLENGTH="100" SIZE="40">';
	echo ' and <INPUT TYPE="NUMBER" NAME="droppedgold" SIZE="4" MIN="1" MAX="9999"> gold pieces.';
	echo '<INPUT TYPE="HIDDEN" NAME="droptype" VALUE="1"><INPUT TYPE="HIDDEN" NAME="location" VALUE="' . $locid .'">';
	echo '<INPUT TYPE="HIDDEN" NAME="chartoon" VALUE="' . $toonid .'">';
	echo ' <BR /><INPUT TYPE="SUBMIT" VALUE="Click me!"></FORM></CENTER><BR />';
} else if ($whatdropped == "2"){
	echo '<CENTER><FORM METHOD="POST" ACTION="gw-insert.php">';
	echo 'on <INPUT NAME="treasuredate" TYPE="DATE" PLACEHOLDER="2006-10-26"> a ';
	//code for what rare material dropped
	$sqlraremat = "SELECT * FROM `materials` ORDER BY `materialid` ASC";
	if (!$result = $con->query($sqlraremat)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo '<SELECT NAME="rarematerial">';
	while ($row = $result->fetch_array()){
		$matid = $row['materialid'];
		$raremat = $row['material'];
		echo '<OPTION VALUE="' . $matid . '">' . $raremat . '</OPTION>';
	}
	echo '</SELECT> ';
	echo ' and <INPUT TYPE="NUMBER" NAME="droppedgold" SIZE="4" MIN="1" MAX="9999"> gold pieces.';
	echo '<INPUT TYPE="HIDDEN" NAME="droptype" VALUE="2"><INPUT TYPE="HIDDEN" NAME="location" VALUE="' . $locid .'">';
	echo '<INPUT TYPE="HIDDEN" NAME="chartoon" VALUE="' . $toonid .'">';
	echo ' <BR /><INPUT TYPE="SUBMIT" VALUE="Click me!"></FORM></CENTER><BR />';
} else if ($whatdropped == "3"){
	echo '<CENTER><FORM METHOD="POST" ACTION="gw-insert.php">';
	echo 'on <INPUT NAME="treasuredate" TYPE="DATE" PLACEHOLDER="2006-10-26"> a ';
	echo '<SELECT NAME="runerarity"><OPTION VALUE="2">Blue</OPTION><OPTION VALUE="3">Purple</OPTION><OPTION VALUE="4">Gold</OPTION></SELECT> ';
	//code for what rune dropped
	$sqlrune = "SELECT * FROM `listrunes` ORDER BY `runeid` ASC";
	if (!$result = $con->query($sqlrune)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo 'rune of <SELECT NAME="rune">';
	while ($row = $result->fetch_array()){
		$runeid = $row['runeid'];
		$rune = $row['runes'];
		echo '<OPTION VALUE="' . $runeid . '">' . $rune . '</OPTION>';
	}
	echo '</SELECT> ';
	echo ' and <INPUT TYPE="NUMBER" NAME="droppedgold" SIZE="4" MIN="0" MAX="9999"> gold pieces.';
	echo '<INPUT TYPE="HIDDEN" NAME="droptype" VALUE="3"><INPUT TYPE="HIDDEN" NAME="location" VALUE="' . $locid .'">';
	echo '<INPUT TYPE="HIDDEN" NAME="chartoon" VALUE="' . $toonid .'">';
	echo ' <BR /><INPUT TYPE="SUBMIT" VALUE="Click me!"></FORM></CENTER><BR />';
} else if ($whatdropped == "4"){
	echo '<CENTER><FORM METHOD="POST" ACTION="gw-insert.php">';
	echo 'on <INPUT NAME="treasuredate" TYPE="DATE" PLACEHOLDER="2006-10-26" VALUE="' . date('Y-m-d') . '"> nothing dropped! Maybe try again in 30 days on: ' . date('Y-m-d', strtotime("+30 days"));
	echo '<INPUT TYPE="HIDDEN" NAME="droppedgold" VALUE="0"><INPUT TYPE="HIDDEN" NAME="itemname" VALUE="Nothing dropped!">';
	echo '<INPUT TYPE="HIDDEN" NAME="droptype" VALUE="4"><INPUT TYPE="HIDDEN" NAME="location" VALUE="' . $locid .'">';
	echo '<INPUT TYPE="HIDDEN" NAME="itemtype" VALUE="17"><INPUT TYPE="HIDDEN" NAME="chartoon" VALUE="' . $toonid .'">';
	echo ' <BR /><INPUT TYPE="SUBMIT" VALUE="Click me!"></FORM></CENTER><BR />';
} else {
	echo '<CENTER><FORM METHOD="POST"><SELECT NAME="gwdrop" onchange="this.form.submit()">';
	echo '<OPTION SELECTED DISABLED>choose one</OPTION>';
	echo '<OPTION VALUE="1">Weapon</OPTION>';
	echo '<OPTION VALUE="2">Rare Material</OPTION>';
	echo '<OPTION VALUE="3">Rune</OPTION>';
	echo '<OPTION VALUE="4">Nothing!</OPTION></SELECT>';
	echo '<INPUT TYPE="HIDDEN" NAME="locationid" VALUE="' . $location . '">';
	echo '<INPUT TYPE="HIDDEN" NAME="playerid" VALUE="' . $toonid .'">';
	echo '<NOSCRIPT><INPUT TYPE="SUBMIT" VALUE="SUBMIT"></NOSCRIPT></FORM></CENTER>';
}
?>
<BR />
<CENTER>
<FORM METHOD="POST" ACTION="gw-location.php">
<INPUT TYPE="HIDDEN" NAME="cnameid" VALUE="0">
<INPUT TYPE="SUBMIT" VALUE="Return to location selection">
</FORM>
</CENTER>
<!-- really need to make a footer page for this -->
<BR /><BR /><CENTER><FORM METHOD="POST" ACTION="gw-logout.php"><INPUT TYPE="HIDDEN" NAME="logout"><INPUT TYPE="SUBMIT" VALUE="Logout"></FORM></CENTER>
</BODY>
</HTML>
