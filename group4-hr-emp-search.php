<!DOCTYPE html>
<html lang="en">
<head>
		<!--Name:
				filename: group4-hr-lastName-search.php
				Blackboard Username: zrhines
				Class Section: CTI.110.0004
				Purpose: Group Project
		-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HR Employee Search</title>
	<link href="group4-hr-style.css" type="text/css" rel="stylesheet" />
  <style>
    body {
      width: unset;
    }
  </style>
</head>
<body>
<div class="container">
	<header>
		<h1>HR Employee Search Results</h1>
	</header>
<main>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('db-connection.php');
$connect = mysqli_connect($server, $user, $pw, $db);
if (!$connect) { 
    print("ERROR: Cannot connect to database $db on server $server using username $user ("
        . mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
}

$where = ";";
if (isset($_POST['empID'])) {
  $empID = $_POST['empID'];
  $where = " where employee_id = $empID;";
}
if (isset($_POST['lastName'])) {
  $lastName = $_POST['lastName'];
  $where = " where last_name like '%$lastName%';";
}

$query = "select * from employees join jobs "
       . "on employees.job_id = jobs.job_id "
       . $where;

$result = mysqli_query($connect, $query);
if (!$result) {
    print("Could not successfully run query. Press back to return."
        . mysqli_error($connect) );
}

if (mysqli_num_rows($result) == 0) { 
   print("No records found with query $empID");
} else {
    echo "<table>";
    echo "<tr><th>Employee ID</th><th colspan=2>Name</th><th>Email</th><th>Phone</th><th>Job Code</th><th>Job Title</th><th>Salary</th><th>Hire Date</th><th>Department</th><th>Dept ID</th><th>Manager</th><th>Manager ID</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      $empID = $row['employee_id'];
		  $firstName = $row['first_name'];
      $lastName = $row['last_name'];
      $email = $row['email'];
      $phone_number = $row['phone_number'];
      $hire_date = $row['hire_date'];
      $manager_id = $row['manager_id'];
      $department_id = $row['department_id'];        
		  $jobCode = $row['job_id'];
		  $jobTitle = $row['job_title'];
		  $salary = $row['salary'];

      // lookup department name
      $query2 = "select department_name from departments where department_id = $department_id;";
      $result2 = mysqli_query($connect, $query2);
      if ($result2 && (mysqli_num_rows($result2) > 0)) {
        $row2 = mysqli_fetch_assoc($result2);
        $department = $row2['department_name'];    
      } else {
        $department = $department_id;
      }
      
      // lookup manager name
      $query3 = "select first_name,last_name from employees where employee_id = $manager_id;";
      $result3 = mysqli_query($connect, $query3);
      if ($result3 && (mysqli_num_rows($result3) > 0)) {
        $row3 = mysqli_fetch_assoc($result3);
        $manager = $row3['last_name'];    
      } else {
          $manager = "N/A";
          $manager_id = "N/A";
      }
      echo "<tr><td>$empID</td><td>$firstName</td><td>$lastName</td><td>$email</td><td>$phone_number</td><td>$jobCode</td><td>$jobTitle</td><td>$" 
           . number_format($salary, 2) . "</td><td>$hire_date</td><td>$department</td><td>$department_id</td><td>$manager</td><td>$manager_id</td></tr>";
    }
    echo "</table>";
}


mysqli_close($connect);
?>
</main>
<footer>
  <br>
  <br>
<a href="group4-hr-emp-search.html">Return to Employee Search</a>
</footer>
</div>
</body>
</html>


