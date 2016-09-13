<?php //fetchrow.php
  require_once 'login_CPI.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $query  = "SELECT * FROM steps_ID";
  $result = $conn->query($query);
  if (!$result) die($conn->error);

  $rows = $result->num_rows;

  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
			// fewer calls to interrogate the result object
			
    echo 'Process: '   . $row['PROCESS_DESC']   . '<br>';
    echo 'Sub size: '    . $row['SUB_DIM']    . '<br>';
    echo 'Tool: ' . $row['TOOL'] . '<br>';
    echo 'Recipe: '     . $row['RECIPE']     . '<br>';
    echo 'Details: '     . $row['DETAILS']     . '<br><br>';
	
  }

  echo $rows;
  
  $result->close();
  $conn->close();
?>