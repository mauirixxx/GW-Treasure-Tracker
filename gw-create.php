<!DOCTYPE html>
<HTML>
<HEAD>
<link rel="stylesheet" type="text/css" href="gw-style.css">
<TITLE>Character Creation</TITLE>
</HEAD>
<BODY>
<CENTER>
<?php
session_start();
include_once 'gw-connect.php';
$con = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
$createnew = mysqli_real_escape_string($con, $_POST['docreate']);
$userid = $_SESSION['userid'];
if ($createnew === "1"){
	$cname = mysqli_real_escape_string($con, $_POST['cname']);
	$bdate = mysqli_real_escape_string($con, $_POST['bdate']);
	$profid = mysqli_real_escape_string($con, $_POST['professionid']);
	function getColor() {
		return array("#FFF", "#DDD", "#FF8", "#CF9", "#ACF", "#9FC", "#DAF", "#FBB", "#FCE", "#BFF", "#FC9", "#DDF");
	}
	$profcolor = getColor()[$profid];
	list ($y, $m, $d) = explode('-', $bdate);
	if (!checkdate($m, $d, $y)) {
		echo 'Date is invalid ' . $bdate . '<BR />';
		echo 'Date format is YYYY-MM-DD / 2005-04-28<BR />';
		echo 'Please click <A HREF="gw-create.php" CLASS="navlink">HERE</A> to try again';
		echo '<BR /><BR />Return to <A HREF="gw-index.php" CLASS="navlink">home</A>.</CENTER></BODY></HTML>';
		exit();
	} else if ($cname === ""){
		echo 'Please enter a name for your character<BR />';
		echo 'Please click <A HREF="gw-create.php" CLASS="navlink">HERE</A> to try again';
		echo '<BR /><BR />Return to <A HREF="gw-index.php" CLASS="navlink">home</A>.</CENTER></BODY></HTML>';
		exit();
	} else if ($profid === ""){
		echo 'Please choose a profession<BR />';
		echo 'Please click <A HREF="gw-create.php" CLASS="navlink">HERE</A> to try again';
		echo '<BR /><BR />Return to <A HREF="gw-index.php" CLASS="navlink">home</A>.</CENTER></BODY></HTML>';
		exit();
	}
	$sqlcreate = "INSERT INTO `playername` (charname, birthdate, userid, professionid, profcolor) VALUES ('$cname', '$bdate', $userid, $profid, '$profcolor')";
	if (!$resultcreate = $con->query($sqlcreate)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	header("refresh:3;url=gw-toon.php");
} else {
	echo '<CENTER><FORM METHOD="POST" ACTION="gw-create.php"><INPUT TYPE="HIDDEN" NAME="docreate" VALUE="1">';
	echo 'Character name: <INPUT TYPE="TEXT" NAME="cname" MAXLENGTH="19" SIZE="20"><BR />';
	echo 'Birthdate: <INPUT NAME="bdate" TYPE="DATE" PLACEHOLDER="2005-04-28"><BR />';
	$sqlprofession = "SELECT * FROM (SELECT * FROM listruneprofessions ORDER BY runeprofid DESC LIMIT 10) sub ORDER BY runeprofid ASC";
	if (!$result = $con->query($sqlprofession)){
		die ('There was an error running the query [' . $con->error . ']');
	}
	echo 'Profession: <SELECT NAME="professionid">';
	echo '<OPTION SELECTED DISABLED>Choose Profession</OPTION>';
	while ($row = $result->fetch_array()){
		$professionid = $row['runeprofid'];
		$profession = $row['runeprofession'];
		echo '<OPTION VALUE="' . $professionid . '">' . $profession . '</OPTION>';
	}
	echo '</SELECT><BR /><BR /> ';
	echo '<INPUT TYPE="SUBMIT" VALUE="Create character ..."></FORM>';
}
?>
<BR /><BR />
Return to <A HREF="gw-index.php" CLASS="navlink">home</A>.
</CENTER>
<BR /><BR /><CENTER><FORM METHOD="POST" ACTION="gw-logout.php"><INPUT TYPE="HIDDEN" NAME="logout"><INPUT TYPE="SUBMIT" VALUE="Logout"></FORM></CENTER>
</BODY>
</HTML>