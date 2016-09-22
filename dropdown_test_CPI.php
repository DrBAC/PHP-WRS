<?php

include ("login_CPI.php");

$link = mysqli_connect($hn, $un, $pw, $db);

if (mysqli_connect_errno()) die(mysqli_connect_error());

$result = mysqli_query($link, "SELECT DISTINCT`PROCESS_DESC` FROM `steps_ID`");

echo "<form action=\"dropdown_test_CPI.php\" method=\"post\">";

echo	"<div class=\"label\">Select Process:</div>";
echo	"<select name=\"Process\">";
echo	"<option value = \"\">---Select---</option>";
while ( $d=mysqli_fetch_assoc($result)) 
	{
		$procdesc = $d['PROCESS_DESC'];
		echo "<option value='{".$d['PROCESS_DESC']."}'>".$d['PROCESS_DESC']."</option>";
		}
	echo	"</select>";
	
echo "<input type=\"submit\" value=Search>";

echo "</form>";

 if (isset($_POST['Process']))
 {
	 $choice = $_POST['Process'];
	 $sql = "SELECT * FROM steps_ID WHERE PROCESS_DESC='$choice'";
	 $response = mysqli_query($link, $sql);


  echo "<br><table><tr><th>Step ID</th><th>Process Description</th><th>Tool</th><th>Recipe</th><th>Details</th></tr>"; //HEAD OF TABLE

 while($row = mysqli_fetch_array($response, MYSQLI_ASSOC))
  {
  	echo "<tr>";

	echo "<td>$row[STEP_ID]</td><td>$row[PROCESS_DESC]</td><td>$row[TOOL]</td><td>$row[RECIPE]</td><td>$row[DETAILS]</td>
	<td></form></td>";
  	
	echo "</tr>";
  }
  echo "</table>";
	mysqli_free_result($response);
	
	 
 }

?>