<?php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $query  = "INSERT INTO cats VALUES(NULL, 'Cheetah', 'Charly', 3)";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);
?>
