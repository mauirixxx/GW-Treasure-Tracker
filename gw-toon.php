<?php
include_once 'gw-connect.php';
$con = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
$userid = 1; //need to actually pull this info from cookie/session (preferable)
$whattoon = mysqli_real_escape_string($con, $_POST['cname']);
if ($con->connect_errno > 0){
	die ('Unable to connect to database [' . $db->connect_errno . ']');
}
$sql = "SELECT playerid, charname FROM `playername` WHERE `userid` = '1' ORDER BY `charname` ASC"; //need to make userid a variable
if (!$result = $con->query($sql)){
	die ('There was an error running the query [' . $con->error . ']');
}
# experimental stuff
if ($whattoon == ""){
	echo '<CENTER><FORM METHOD="POST">';
	echo '<SELECT NAME="cname" onchange="this.form.submit()">>';
	echo '<OPTION SELECTED DISABLED>Select a Character</OPTION>';
	while ($row = $result->fetch_array()){
		$charid = $row['playerid'];
		$charname = $row['charname'];
		echo '<OPTION VALUE="' . $charid . '">' . $charname . '</OPTION>';
	}
	echo '</SELECT><NOSCRIPT><INPUT TYPE="SUBMIT" VALUE="Choose Toon"></NOSCRIPT></FORM></CENTER>';
} else {
	echo 'Options for what to do after character selection goes here <BR />';
	echo 'Character id selected is ' . $whattoon . '<BR />';
}
?>