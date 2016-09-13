<?php
include ("login_CPI.php");

$conn = new mysqli($hn, $un, $pw, $db);

if (!$conn) {
  exit('Connect Error (' . mysqli_connect_errno() . ') '
       . mysqli_connect_error());
} 
?>

    <div class="label">Select Author:</div>

    <select name="names">
    <option value = "">---Select---</option>
    <?php
    $queryusers = "SELECT `PROCESS_DESC` FROM `steps_ID` ";
    $conn = mysqli_query($conn, $queryusers);
    while ( $d=mysqli_fetch_assoc($conn)) {
      echo "<option value='{".$d['PROCESS_DESC']."}'>".$d['PROCESS_DESC']."</option>";
    }
    ?>
      </select>  