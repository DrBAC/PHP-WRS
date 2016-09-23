
<?php

include ("login_CPI.php");

$link = mysqli_connect($hn, $un, $pw, $db);

if (mysqli_connect_errno()) die(mysqli_connect_error());

//$result = mysqli_query($link, "SELECT DISTINCT PROCESS_DESC FROM steps_ID");

$result = mysqli_query($link, "SELECT DISTINCT PROCESS_DESC FROM steps_ID");



// ---------------------------------------------------------------------------------------------------------------- //

				//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//
				//   set up form, including drop-down box and Search Button   //
				//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//-//

echo

<<<_END

<form action="dropdown_test_CPI.php" method="post">

<div class=\"label\">	Select Process:	</div>

<select name="Process">

<option value = "">		---Select---	</option>

_END;

while($d=mysqli_fetch_assoc($result)) 
	{
		$procdesc = $d['PROCESS_DESC'];
		echo "<option value='{".$d['PROCESS_DESC']."}'>".$d['PROCESS_DESC']."</option>";
	}

echo

<<<_END

</select>
	
<input type="submit" value=Search>

</form>

_END;

// ---------------------------------------------------------------------------------------------------------------- //

if (isset($_POST['Process']))			//sees if form was used (selection - press search)
{
	$choice = trim(strip_tags($_POST['Process']));
	
	$response = mysqli_query($link, "SELECT * FROM steps_ID WHERE PROCESS_DESC = '$choice'");
	
//	$rows = $response->num_rows;

// create table header
	 
echo
<<<_TABHEAD

	<br>
	<table>
	<tr>
	<th>Step ID</th>
	<th>Process Description</th>
	<th>Tool</th>
	<th>Recipe</th>
	<th>Details</th>
	</tr>

_TABHEAD;
 
//	for ($j = 0 ; $j < $rows ; ++$j)

//		$response->data_seek($j);

//		$row = $response->fetch_array(MYSQLI_ASSOC);

while($row = mysqli_fetch_array($response, MYSQLI_BOTH))
{
	echo "<tr>";
	echo "<td>" . $row['STEP_ID'] . "</td>";
	echo "<td>" . $row['PROCESS_DESC'] . "</td>";
	echo "<td>" . $row['TOOL'] . "</td>";
	echo "<td>" . $row['RECIPE'] . "</td>";
	echo "<td>" . $row['DETAILS'] . "</td>";
	echo "<td></form></td>";
  	
	echo "</tr>";
	}
	echo "</table>";
	
//	mysqli_free_result($response);
	
	 echo "$choice";
	//echo $response;
 }

?>