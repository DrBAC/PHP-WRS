<body>

    <form method="get" action="http://www.yourwebskills.com/files/examples/process.php">
        
        <select id="cd" name="cd">
        
            <?php
            
			include ("login_CPI.php");

			$link = mysqli_connect($hn, $un, $pw, $db);

			if (mysqli_connect_errno()) die(mysqli_connect_error());
          
            $result = mysqli_query($link, "SELECT DISTINCT`PROCESS_DESC` FROM `steps_ID`");
            
            while ($ddchoice1=mysqli_fetch_assoc($result)) 
			{
            $procdesc=$ddchoice1["PROCESS_DESC"];
			
			echo "<option> $procdesc </option>";
            }
                
			echo $procdesc
            ?>

        </select>
        
    </form>
    
</body>  