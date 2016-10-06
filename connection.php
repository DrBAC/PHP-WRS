<?php
	$con = mysqli_connect("localhost","root","","tuts");
	
	
	//check our connection
	if (mysqli_connect_errno())	{
		echo "Failed to connect:" .mysqli_connect_errno();
	}
	
?>