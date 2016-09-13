<?php // SQLInsert_Example.php
  
  
//-------------------------------------------------------------------------------
  
require_once 'login.php';
//  pulls in login file
  
$conn = new mysqli($hn, $un, $pw, $db);
//  creates $conn object - new instance of mysqli method; values retreived from login file
  
if ($conn->connect_error) die($conn->connect_error);
//  error checking done on last line - if connect error has a value, this is passed to $conn, which calls the die function (basically means can't connect to the desired database)
  
//-------------------------------------------------------------------------------
  
// looks at if $_POST has been set for 'delete' and 'isbn' -- ie has the DELETE RECORD been selected??

if (isset($_POST['delete']) && isset($_POST['isbn']))
{

// gets isbn num from the relevant entry and assigns to $isbn
$isbn   = get_post($conn, 'isbn');

// creates $query variable whish is a SQL call to remove based on the $isbn value
$query  = "DELETE FROM classics WHERE isbn='$isbn'";

// assigns result of
$result = $conn->query($query);

if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
  }
// 
  
//--------------------------------------------------------------------------------
 
// this section looks into the ADDING RECORD form area by a series of ISSET calls
// here an array called $_POST is filled with the relevant form-completed info

if (isset($_POST['author'])   &&
isset($_POST['title'])    &&
isset($_POST['category']) &&
isset($_POST['year'])     &&
isset($_POST['isbn']))

{
$author   = get_post($conn, 'author');
$title    = get_post($conn, 'title');
$category = get_post($conn, 'category');
$year     = get_post($conn, 'year');
$isbn     = get_post($conn, 'isbn');
$query    = "INSERT INTO classics VALUES" . "('$author', '$title', '$category', '$year', '$isbn')";
$result   = $conn->query($query);
if (!$result) echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
  }
  
//--------------------------------------------------------------------------------
  

		//*******        INPUT FORM AT TOP OF SHEET      *******//
  
 echo <<<_END
  
  <form action="SQLInsert_Example.php" method="post">
  
  <pre>
    Author <input type="text" name="author">
     Title <input type="text" name="title">
  Category <input type="text" name="category">
      Year <input type="text" name="year">
      ISBN <input type="text" name="isbn">
           <input type="submit" value="ADD RECORD">
  </pre>
  </form>
  
_END;

// form is set up as POST - avoids sending data thru the browser address bar!!!

/*
echo <<<_END

<pre><form action="SQLInsert_Example.php" method="post">
	<table>
		<tr>
			<th>Property</th>
			<th>Input</th>
		</tr>
		<tr>
			<td> Author </td>
			<td> <input type="text" name="author"> </td>
		</tr>
		<tr>
			<td> Title </td>
			<td> <input type="text" name="title"></td>
		</tr>
		<tr>
			<td> Category </td>
			<td> <input type="text" name="category"> </td>
		</tr>
		<tr>
			<td> Year </td>
			<td> <input type="text" name="year"> </td>
		</tr>
		<tr>
			<td> ISBN </td>
			<td> <input type="text" name="isbn"> </td>
		</tr>
		<tr>
			<td> --- </td>
			<td> <input type="submit" value="ADD RECORD"> </td>
		</tr>
 
  </form></pre>
_END;
*/

//--------------------------------------------------------------------------------

// initiates some variables to hold the query and the result
$query  = "SELECT * FROM classics";
$result = $conn->query($query);
 
// if no result,  kills the program and yields the error
if (!$result) die ("Database access failed: " . $conn->error);

// num_rows is passed as $result, also $rows
$rows = $result->num_rows;
  
//--------------------------------------------------------------------------------
  
for ($j = 0 ; $j < $rows ; ++$j) 
{
$result->data_seek($j);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo <<<_END

  <pre>
  
 <table>
		<tr>
			<th>Author</th>
			<th>Title</th>
			<th>Category</th>
			<th>Year</th>
			<th>ISBN</th>
		</tr> 
  
    Author $row[author]
     Title $row[title]
  Category $row[category]
      Year $row[year]
      ISBN $row[isbn]
  </pre>
  
  <form action="SQLInsert_Example.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="isbn" value="$row[isbn]">
  <input type="submit" value="DELETE RECORD"></form>
  
_END;
}
  

//--------------------------------------------------------------------------------  
  
// closes objects which otherwise would have lots of memory stored within them  
  
  $result->close();
  $conn->close();
  
//--------------------------------------------------------------------------------

 // THIS FUNCTION REMOVES ANY DODGY CHARS FROM HACKERS GETTING THRU
 
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
?>
