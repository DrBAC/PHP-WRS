<?php // sql_Proc_draft.php

  require_once 'login_CPI.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  //  creates $conn object - new instance of mysqli method; values retreived from login file
  //  error checking done on last line - if connect error has a value, this is passed to $conn, which calls the die function (basically means can't connect to the desired database)
  
  if (isset($_POST['delete']) && isset($_POST['PROCESS_DESC']))
  {
    $procdesc   = get_post($conn, 'PROCESS_DESC');
    $query  = "DELETE FROM steps_ID WHERE PROCESS_DESC='$procdesc'";
    $result = $conn->query($query);
  	if (!$result) echo "DELETE failed: $query<br>" .
      $conn->error . "<br><br>";
  }

  if (isset($_POST['SUB_DIM'])   &&
      isset($_POST['TOOL'])    &&
      isset($_POST['RECIPE']) &&
      isset($_POST['DETAILS'])     &&
      isset($_POST['PROCESS_DESC']))
  {
    $subsize   		= get_post($conn, 'SUB_DIM');
    $tool    		= get_post($conn, 'TOOL');
    $recipe 		= get_post($conn, 'RECIPE');
    $details     	= get_post($conn, 'DETAILS');
	$prompt			= get_post($conn, 'PROMPT');
    $procdesc		= get_post($conn, 'PROCESS_DESC');
	$filmthickness	= get_post($conn, 'FILM_THICKNESS');
	$location		= get_post($conn, 'LOCATION');
	$maskid			= get_post($conn, 'MASK_ID');
    $query    = "INSERT INTO steps_ID VALUES" .
      "('$subsize', '$tool', '$recipe', '$details', '$prompt', '$procdesc', '$filmthickness', '$location', '$maskid', DEFAULT)";
    $result   = $conn->query($query);

  	if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
  }
//--------------------------------------------------------//
///////					THE FORM				///////
  echo 
  <<<_END
  <form action="sql_PROC_draft.php" method="post">
  <pre>
  Process Description 		<input type="text" name="PROCESS_DESC">
  Details 			<input type="text" name="DETAILS">
  Tool 				<input type="text" name="TOOL">
  Recipe			<input type="text" name="RECIPE">
  Prompt 			<input type="text" name="PROMPT">
  Substrate Size		<input type="text" name="SUB_DIM">
  Film Thickness		<input type="text" name="FILM_THICKNESS">
  Location			<input type="text" name="LOCATION">
  MASK ID			<input type="text" name="MASK_ID">

  <input type="submit" value="ADD RECORD">

  </pre>

  </form>
_END;

  $query  = "SELECT * FROM steps_id";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
?>

  <select name="names">
  <option value = "">---Select---</option>

  <?php
  $queryusers = "SELECT DISTINCT `PROCESS_DESC` FROM `steps_ID` ";
  $conn = mysqli_query($conn, $queryusers);
  while ( $d=mysqli_fetch_assoc($conn)) {
  echo "<option value='{".$d['PROCESS_DESC']."}'>".$d['PROCESS_DESC']."</option>";
  echo 'names';
  }?>
  
</select>    

<?php
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
///////				THE REPEATING OUTPUT SETUP			///////
  
  $rows = $result->num_rows;
  echo "<br><br><table><tr><th>Step ID</th><th>Process Description</th><th>Tool</th><th>Recipe</th><th>Details</th></tr>";

  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
  	$row = $result->fetch_array(MYSQLI_ASSOC);

  	echo "<tr>";
  	//for ($k = 0 ; $k < 10 ; ++$k) 
	echo "<td>$row[STEP_ID]</td><td>$row[PROCESS_DESC]</td><td>$row[TOOL]</td><td>$row[RECIPE]</td><td>$row[DETAILS]</td>
	<td><form action=\"sql_Proc_draft.php\" method=\"post\">
	<input type=\"hidden\" name=\"delete\" value=\"yes\">
	<input type=\"hidden\" name=\"PROCESS_DESC\" value=\"$row[PROCESS_DESC]\">
	<input type=\"submit\" value=\"DELETE RECORD\"></form></td>";
  	
	echo "</tr>";
  }
  echo "</table>";
	  
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//
///////						THE OUTPUT					///////
/*	
	echo <<<_END
	
	Process: $row[PROCESS_DESC] <br>
	Sub Size: $row[SUB_DIM] <br>
	Tool: $row[TOOL] <br>
	Recipe: $row[RECIPE] <br>
	Details: $row[DETAILS]

	<form action="sql_Proc_draft.php" method="post">
	<input type="hidden" name="delete" value="yes">
	<input type="hidden" name="PROCESS_DESC" value="$row[PROCESS_DESC]">
	<input type="submit" value="DELETE RECORD"></form>
  
_END;
*/


  $result->close();   		 //	 	returns memory
  $conn->close();			 // 		returns memory
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
