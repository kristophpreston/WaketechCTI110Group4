<!DOCTYPE html>
<html lang="en">
<head>
		<!--Name:
				filename: group4-hr-dept-search.php
				Blackboard Username: nswilson
				Class Section: CTI.110.0004
				Purpose: Group Project
		-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Location Search Results</title>
	<link href="group4-hr-style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="container">
	<header>
		<h1>HR Location Search Results</h1>
	</header>
<main>
<?php
include('db-connection.php');
$connect = mysqli_connect($server, $user, $pw, $db);
if (!$connect) { 
    die("ERROR: Cannot connect to database $db on server $server using username $user ("
        . mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
}

$location = $_POST['location'];

$query = "select * from locations where city = '$location';";

$result = mysqli_query($connect, $query);
if (!$result) {
    die("Could not successfully run query ($query) from $db: "
        . mysqli_error($connect) );
}

if (mysqli_num_rows($result) == 0) { 
   print("No records found with query $query");
} else {
    $row = mysqli_fetch_assoc($result);
    $street_address = $row['street_address'];
    $city = $row['city'];
    $state = $row['state_province'];
    $postal_code = $row['postal_code'];
    $location_id = $row['location_id'];
    echo "<h2>$street_address, <b>$city</b>";
    if ($state != null) {
        echo ", $state";
    }
    if ($postal_code != null) {
        echo " $postal_code";
    }
    echo "</h2>";

    $query = "select * from departments where location_id = '$location_id';";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        die("Could not successfully run query ($query) from $db: "
            . mysqli_error($connect) );
    }
    if (mysqli_num_rows($result) == 0) { 
       print("No records found with query $query");
    } else {
        echo "<table>";
        echo "<caption>Employees in $city by Department</caption>";
        while ($row = mysqli_fetch_assoc($result)) {
            $dept = $row['department_name'];
            $dept_id = $row['department_id'];
            echo "<tr><th colspan=4>$dept</th></tr>";
            $query = "select * from employees where department_id = '$dept_id' order by last_name;";
            $result2 = mysqli_query($connect, $query);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $first = $row2['first_name'];
                $last = $row2['last_name'];
                $email = $row2['email'];
                $phone = $row2['phone_number'];
                echo "<tr><td>$first</td><td>$last</td><td>$email</td><td>$phone</td></tr>";
            }
        }
        echo "</table>";
    }
}

mysqli_close($connect);
?>
</main>
<footer>
<a href="group4-hr-dept-search.html">Return to Department/Location Search</a>
</footer>
</body>
</html>



