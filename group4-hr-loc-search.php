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
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('db-connection.php');
$connect = mysqli_connect($server, $user, $pw, $db);
if (!$connect) { 
    die("ERROR: Cannot connect to database $db on server $server using username $user ("
        . mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
}

$location = $_POST['location'];
echo "<header>
<h1>HR Location Search Results for <i>$location</i></h1>
</header>
<main>";

$query = "select * from (locations join countries on locations.country_id = countries.country_id) join regions on countries.region_id = regions.region_id where city = '$location';";

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
    echo "<h4>$street_address<br><b>$city</b>";
    if ($state != null) {
        echo ", $state";
    }
    if ($postal_code != null) {
        echo " $postal_code";
    }
    if ($country = $row['country_name']) {
        echo "<br>$country<br>" . $row['region_name'];
    }
    echo "</h4>";

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
        echo "<tr><th>Department</th><th colspan='2'>Name</th><th>Email</th><th>Phone</th><th>Job</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            $dept = $row['department_name'];
            $dept_id = $row['department_id'];
            $query = "select * from employees join jobs on employees.job_id = jobs.job_id where department_id = '$dept_id' order by last_name;";
            $result2 = mysqli_query($connect, $query);
            $count2 = mysqli_num_rows($result2);
            if ($count2 > 0) {
                echo "<tr><th rowspan='$count2' scope='row'>$dept</th>";
                $row2 = mysqli_fetch_assoc($result2);
                $first = $row2['first_name'];
                $last = $row2['last_name'];
                $email = $row2['email'];
                $phone = $row2['phone_number'];
                $job = $row2['job_title'];
                echo "<td>$first</td><td>$last</td><td>$email</td><td>$phone</td><td>$job</td></tr>";
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $first = $row2['first_name'];
                    $last = $row2['last_name'];
                    $email = $row2['email'];
                    $phone = $row2['phone_number'];
                    echo "<tr><td>$first</td><td>$last</td><td>$email</td><td>$phone</td><td>$job</td></tr>";
                }
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
</div>
</body>
</html>



