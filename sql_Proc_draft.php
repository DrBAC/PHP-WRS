<?php // sql_Proc_draft.php

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//

  require_once 'login_CPI.php';
  //  pulls in login file
  $conn = new mysqli($hn, $un, $pw, $db);
  //  creates $conn object - new instance of mysqli method; values retreived from login file
  if ($conn->connect_error) die($conn->connect_error);
//  error checking done on last line - if connect error has a value, this is passed to $conn, which calls the die function (basically means can't connect to the desired database)o the desired database)

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//

								//////			CHECKING FOR DELETION REQUESTS			/////
								
   if (isset($_POST['delete']) && isset($_POST['PROCESS_DESC']))
// looks at if $_POST has been set for 'delete' and 'isbn' -- ie has the DELETE RECORD been selected??
	   {
    $procdesc   = get_post($conn, 'PROCESS_DESC');
    $query  = "DELETE FROM steps_ID WHERE PROCESS_DESC='$procdesc'";
// if so it looks at the process desc value and builds a request to remove the relevant entry from the db, and assigns that to the $query variable
    $result = $conn->query($query);
// this query is then sent to the db, and this action assigned to the variable $result

  	if (!$result) echo "DELETE failed: $query<br>" .
      $conn->error . "<br><br>";
//if this fails it reports the error

  }

								///////			CHECKING FOR ADDITION REQUESTS			//////
  
  if (isset($_POST['SUB_DIM']) && isset($_POST['TOOL']) && isset($_POST['RECIPE']) && isset($_POST['DETAILS']) && isset($_POST['PROCESS_DESC']))
// looks to see if variable $_POST['SUB_DIM'] and other db field titles have been set

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
// if $_POST['db Fields'] have values, these are passed thru the get_post function to sanitize/secure their input into the db, assigned to new variables $variable, and this added as an array of variables to the $query variable, which just inserts them whole sale into the array
	  
    $result   = $conn->query($query);
// $result variable assigned to the action of submitting this query to the db
	
  	if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
// incase of error this returns an error
	  
  }
  
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//

										///////					THE FORM				///////

  echo 
  <<<_END
  <form action="sql_PROC_draft.php" method="post">
  <pre>
  Process Description 		<input type="text" name="PROCESS_DESC"> Details 			<input type="text" name="DETAILS">
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

//			/\/\/\/\/\/\				DROP DOWN BOX			/\/\/\/\/\/\/\



  $queryusers = "SELECT DISTINCT `PROCESS_DESC` FROM `steps_ID` ";
  $conn = mysqli_query($conn, $queryusers);

echo "<select name=\"names\">";
echo "<option value = \"\">---Select---</option>";
while ( $d=mysqli_fetch_assoc($conn)) 
  {
  echo "<option value='{".$d['PROCESS_DESC']."}'>".$d['PROCESS_DESC']."</option>";
  echo 'names';
  }
  
echo "</select>";

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//

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
	  
//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-//
	
							///////				WRAP UP AND MEMORY DUMP			///////
	
  $result->close();   		 //	 	returns memory
  $conn->close();			 // 		returns memory
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
