<!DOCTYPE html>
<html lang="en">
<head>
		<!--Name:
				filename: group4-hr-jobTitle-search.php
				Blackboard Username: zrhines
				Class Section: CTI.110.0004
				Purpose: Group Project
		-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HR Employee Search</title>
	<link href="group4-hr-style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="container">
	<header>
		<h1>HR Job Title Search Results</h1>
	</header>
<main>
<?php
include('db-connection.php');
$connect = mysqli_connect($server, $user, $pw, $db);
if (!$connect) { 
    print("ERROR: Cannot connect to database $db on server $server using username $user ("
        . mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
}
$jobTitle = $_POST['jobTitle'];
$query = "select * from personnel;";

$result = mysqli_query($connect, $query);
if (!$result) {
    print("Could not successfully run query. Press back to return."
        . mysqli_error($connect) );
}

$query = "select * from personnel where jobTitle = '$jobTitle' order by jobTitle;";
$result = mysqli_query($connect, $query);
if (!$result) {
    print("Could not successfully run query. Press back to return."
        . mysqli_error($connect) );
}
if (mysqli_num_rows($result) == 0) { 
   print("No records found with query $query");
} else {
    echo "<table>";
    echo "<caption>Employees</caption>";
	echo "<tr><th>Employee ID</th><th colspan=2>Name</th><th>Job Code</th><th>Job Title</th><th>Salary</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $empID = $row['empID'];
		$firstName = $row['firstName'];
        $lastName = $row['lastName'];
		$jobCode = $row['jobCode'];
		$jobTitle = $row['jobTitle'];
		$salary = $row['salary'];
        echo "<tr><td>$empID</td><td>$firstName</td><td>$lastName</td><td>$jobCode</td><td>$jobTitle</td><td>$salary</td></tr>";
    }
    echo "</table>";
}


mysqli_close($connect);
?>
</main>
<footer>
<a href="group4-hr-job-title.html">Return to Employee Search</a>
</footer>
</body>
</html>


