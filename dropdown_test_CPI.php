<?php

include ("login_CPI.php");

$link = mysqli_connect($hn, $un, $pw, $db);

	if (mysqli_connect_errno()) die(mysqli_connect_error());

	$result_1 = mysqli_query($link, "SELECT DISTINCT`PROCESS_DESC` FROM `steps_ID`");

	echo	"<div class=\"label\">Select Process:</div>";
	echo	"<select name=\"names\">";
	echo	"<option value = \"\">---Select---</option>";
	while ( $d=mysqli_fetch_assoc($result_1)) 
	{
		$procdesc = $d['PROCESS_DESC'];
		echo "<option value='{".$d['PROCESS_DESC']."}'>".$d['PROCESS_DESC']."</option>";
		}

	echo	"</select>";

	echo $procdesc;
	
	?>
	
       