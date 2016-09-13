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
    $subsize   = get_post($conn, 'SUB_DIM');
    $tool    = get_post($conn, 'TOOL');
    $recipe = get_post($conn, 'REIPE');
    $details     = get_post($conn, 'DETAILS');
    $procdesc     = get_post($conn, 'PROCESS_DESC');
    $query    = "INSERT INTO steps_ID VALUES" .
      "('$subsize', '$tool', '$recipe', '$details', '$procdesc')";
    $result   = $conn->query($query);

  	if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
  }

  echo 
  <<<_END
  <form action="sql_PROC_draft.php" method="post">
  <pre>
  
  Process Description 		<input type="text" name="PROCESS_DESC">

  Details 				<input type="text" name="DETAILS">

  Tool 				<input type="text" name="TOOL">

  Recipe				<input type="text" name="RECIPE">

  Prompt 				<input type="text" name="PROMPT">

  <input type="submit" value="ADD RECORD">

  </pre>

  </form>
_END;

  $query  = "SELECT * FROM steps_id";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);

	echo <<<_END
	
	<pre>
	
<table>

<tr> Process: $row[PROCESS_DESC] </tr>
Sub Size: $row[SUB_DIM]
Tool: $row[TOOL]
Recipe: $row[RECIPE]
Details: $row[DETAILS]
  
  </pre>
  
  <form action="sql_Proc_draft.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="PROCESS_DESC" value="$row[PROCESS_DESC]">
  <input type="submit" value="DELETE RECORD"></form>
  
</table>

_END;
  }
  
  $result->close();   		 //	 	returns memory
  $conn->close();			 // 		returns memory
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
