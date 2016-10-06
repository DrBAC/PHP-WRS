
<html>
<head>
	<title> Traveller Filtering </title>
</head>


<?php

include ("login_CPI.php");

$link = mysqli_connect($hn, $un, $pw, $db);

if (mysqli_connect_errno()) die(mysqli_connect_error());


$result1 = mysqli_query($link, "SELECT DISTINCT SUB_DIM FROM steps_ID");


//Because you can close and open php tags when you want it's usually easier to just write the html and do php when you need.
?>
<!--------------------------------------------------------------------------------------------------------------------->

<form action="dropdown_test_CPI.php" method="post">
    <label for="process">Select substrate size:</label>
    <select name="SubstrateSize">
        <option value="">	---Select---	</option>
		
        <?php
            while ($d=mysqli_fetch_assoc($result1)) {
                $subsize = $d['SUB_DIM'];
        ?>
		
        <option value='<?=$subsize; ?>'> <?=$subsize;?></option>		<!--This just means '<php echo' -->
        
		<?php
            }
        ?>
    
	</select>
    <input type="submit" value=Search>
</form>

<?php
$result2 = mysqli_query($link, "SELECT DISTINCT PROCESS_DESC FROM steps_ID WHERE SUB_DIM=$subsize");
?>

<form action="dropdown_test_CPI.php" method="post">
    <label for="process">Select Process:</label>
    <select name="process">
        <option value="">	---Select---	</option>
		
        <?php
            while ($d=mysqli_fetch_assoc($result2)) {
                $procdesc = $d['PROCESS_DESC'];
        ?>
		
        <option value='<?=$procdesc; ?>'> <?=$procdesc;?></option>		<!--This just means '<php echo' -->
        
		<?php
            }
        ?>
    
	</select>
    <input type="submit" value=Search>
</form>


<?php

if (isset($_POST['process'])) {																								//sees if form was used (selection - press search)
	$choice = mysqli_real_escape_string($link, trim(strip_tags($_POST['process']))); 			//This is important to stop injection attacks.
	$response = mysqli_query($link, "SELECT * FROM steps_ID WHERE PROCESS_DESC = '$choice'");
    ?>
<!------------------------------------------------------------------------------------------------------------------->
    <br>
    <table>
        <thead>
            <tr>
                <th>Step ID</th>
                <th>Process Description</th>
                <th>Tool</th>
                <th>Recipe</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
		
    <?php
        while($row = mysqli_fetch_array($response, MYSQLI_ASSOC)) {
    ?>
	
		<tr>
            <td><?=$row['STEP_ID'];?></td>
            <td><?=$row['PROCESS_DESC'];?></td>
            <td><?=$row['TOOL'];?></td>
            <td><?=$row['RECIPE'];?></td>
            <td><?=$row['DETAILS'];?></td>
        </tr>
		
    <?php
        } //endwhile
    ?>
	
        </tbody>
    </table>
	
<?php
} //endif
?>

</html>
