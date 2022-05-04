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
    <title>HR Department/Location Search</title>
    <link href="group4-hr-style.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <header>
            <h1>HR Department Search Results</h1>
        </header>
        <main>
            <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            include('db-connection.php');
            $connect = mysqli_connect($server, $user, $pw, $db);
            if (!$connect) {
                die("ERROR: Cannot connect to database $db on server $server using username $user ("
                    . mysqli_connect_errno() . ", " . mysqli_connect_error() . ")");
            }

            $dept = $_POST['department'];
            $query = "select * from (departments join locations " .
                "on locations.location_id = departments.location_id) join countries on locations.country_id = countries.country_id " .
                "where department_name = '$dept';";

            $result = mysqli_query($connect, $query);
            if (!$result) {
                die("Could not successfully run query ($query) from $db: "
                    . mysqli_error($connect));
            }
            if (mysqli_num_rows($result) == 0) {
                print("No records found with query $query");
            } else {
                $row = mysqli_fetch_assoc($result);
                $department = $row['department_name'];
                $dept_id = $row['department_id'];
                echo "<h2><b>$department</b> Department</h2>";
                $street_address = $row['street_address'];
                $city = $row['city'];
                $state = $row['state_province'];
                $postal_code = $row['postal_code'];
                $location_id = $row['location_id'];
                echo "<h3>$street_address<br><b>$city</b>";
                if ($state != null) {
                    echo ", $state";
                }
                if ($postal_code != null) {
                    echo " $postal_code";
                }
                if ($country = $row['country_name']) {
                    echo "<br>$country";
                }
                echo "</h3>";

                $query = "select * from employees where department_id = '$dept_id' order by last_name;";
                $result = mysqli_query($connect, $query);
                if (!$result) {
                    die("Could not successfully run query ($query) from $db: "
                        . mysqli_error($connect));
                }
                if (mysqli_num_rows($result) == 0) {
                    print("No records found with query $query");
                } else {
                    echo "<table>";
                    echo "<caption>$department Department Employees</caption>";
                    echo "<tr><th colspan=2>Name</th><th>Email</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $email = $row['email'];
                        echo "<tr><td>$first_name</td><td>$last_name</td><td>$email</td></tr>";
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
