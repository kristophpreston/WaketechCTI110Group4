<!DOCTYPE html>
<html lang="en">
<head>
		<!--Name:
				filename: group4-hr-job-title.php
				Blackboard Username: nswilson
				Class Section: CTI.110.0004
				Purpose: Group Project Job Title Search
		-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Job Title Search Results</title>
	<link href="group4-hr-style.css" type="text/css" rel="stylesheet" />
  <style>
    .center {
      text-align: center;
    }
  </style>
</head>
<body>
<div class="container">
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$job = $_POST['jobTitle'];
echo "<header>
<h1>Job Title Search Results for <i>$job</i></h1>
</header>
<main>";

include('db-connection.php');
$connect = mysqli_connect($server, $user, $pw, $db);
if (!$connect) { 
    print("ERROR: Cannot connect to database $db on server $server using username $user ("
        . mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
}

// first find all job titles that match the search string
$query = "select * from jobs where job_title like '%$job%';";
$result = mysqli_query($connect, $query);
if (!$result) {
    print("Could not successfully run query. Press back to return."
        . mysqli_error($connect) );
}
if (mysqli_num_rows($result) == 0) { 
   print("No records found with query $query");
} else {
  echo "<table>";
  // second, for each matching job title, show the average salary
  while ($row = mysqli_fetch_assoc($result)) {
    $jobId = $row['job_id'];
    $jobTitle = $row['job_title'];
    $query2 = "select avg(salary),count(*) from employees where job_id = '$jobId';";
    $result2 = mysqli_query($connect, $query2);
    $row2 = mysqli_fetch_assoc($result2);
    $averageSalary = $row2['avg(salary)'];
    $count = $row2['count(*)'] + 1;
    echo "<tr><th rowspan='$count' scope='row'>$jobTitle</th>";

    $query3 = "select * from employees where job_id = $jobId;";
    $result3 = mysqli_query($connect, $query3);
    echo "<th colspan='2'>Name</th><th>Salary</th>";

    echo "<td rowspan='$count' class='center'>Average Salary<br><b>$" . number_format($averageSalary, 2) . "</b></td></tr>";
    while ($row3 = mysqli_fetch_assoc($result3)) {
      $firstName = $row3['first_name'];
      $lastName = $row3['last_name'];
      $salary = $row3['salary'];
      echo "<tr><td>$firstName</td><td>$lastName</td><td class='right'>$" . number_format($salary, 2) . "</td></tr>";
    }
      
  }
  echo "</table>";
}
mysqli_close($connect);
?>
</main>
<footer>
<a href="group4-hr-job-title.html">Return to Job Search</a>
</footer>
</div>
</body>
</html>


