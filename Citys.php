<?php
	$con = mysqli_connect("localhost","root","","tuts");
	
	
	//check our connection
	if (mysqli_connect_errno())	{
		echo "Failed to connect:" .mysqli_connect_errno();
	}
	
?>



<!DOCTYPE html>
<html>
<head>
	<title> Dropdown AJAX </title>
</head>

<style type="text/css">
	.country, .city{
		margin : 20px;
		text-align: centre;
	}
	
</style>

<body>


<div class = "country">

	<label>Country</label>
	<select name = "country" onchange="getId(this.value);">
		<option value = "">Select Country</option>
		
		<!-- populate values using php -->
		<?php
			$query = "SELECT * FROM country";
			$result = mysqli_query($con, $query);
			// loop
			foreach ($result as $country) {
			?>
		<option value = "<?php echo $country["cid"]; ?>"><?php echo $country["country"]; ?></option>
		<?php
			
				}
			?>
	</select>
</div>


<div class = "city">
	<label>City</label>
	<select name = "city" id="cityList">
		<option value = ""></option>
	
	</select>
</div>

<script   src="https://code.jquery.com/jquery-3.1.1.js"   integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="   crossorigin="anonymous"></script>
<script>
		function getId(val){
			alert(val);
//			$.ajax({
//				type: "POST",
//				url: "getdata.php"
//				data: "cid="+val,
//				success: function(data){
//					$("#cityList").html(data);
				}
	//		});
			
		}
		
</script>



</body>
</html>