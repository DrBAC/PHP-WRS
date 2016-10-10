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
	<title> Dropdown auto complete </title>
</head>

<body>

<p> Select a country: </p>

<div class = "country_selection">

	<label>Country</label>
	<select name = "country_select" onchange="myFunction()"> 
		<option value = "">Select Country</option>
		<?php
			$query = "SELECT * FROM country";
			$result = mysqli_query($con, $query);
			// loop
			foreach ($result as $country) {
			?>
		<option value = "<?php echo $country["country"]; ?>"><?php echo $country["country"]; ?></option>
		<?php
				} //closes loop for first select box
			?>
	</select>
</div>

<p>When you select a new coutry, a function is triggered which outputs the value of the selected country.</p>
<p id="demo"></p>

<script>
function myFunction() {
    var x = document.getElementById("country_select").value;
    document.getElementById("demo").innerHTML = "You selected: " + x;
}
</script>


<!--

<div class = "city">
	<label>City</label>
	<select name = "city" id="cityList">
		<option value = ""> "cid"</option>
	
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
-->


</body>
</html>