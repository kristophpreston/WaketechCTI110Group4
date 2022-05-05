<!DOCTYPE html>
<html lang="en">

<head>
	<!--Name:
				filename: group4-hr-fuel.php
				Blackboard Username: zrhines
				Class Section: CTI.110.0004
				Purpose: Group Project
		-->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Total Fuel Cost</title>
	<link href="group4-hr-style.css" type="text/css" rel="stylesheet" />

	<style>
		p {
			text-align: center;
			font-size: large;
			font-weight: 100;
		}
	</style>

</head>

<body>
	<div class="container">
		<header>
			<h1>Total Fuel Cost</h1>
		</header>
		<main id="fuel">
			<?php
			# The following function is called whenever your program needs to input data.
			# You can change it to use other sources rather than fgets().
			function input()
			{
				return fgets(STDIN);
			}

			$avgMPG = $_POST['avgMPG'];
			$exptCost = $_POST['exptCost'];
			$tripLength = $_POST['tripLength'];
			if ($avgMPG >= 0) {
				if ($exptCost >= 0) {
					if ($tripLength >= 0) {
						$travelCost = $tripLength / $avgMPG * $exptCost;
						print ("<p>Your total travel cost is: $".number_format($travelCost,2)."</p>") . PHP_EOL;
					} else {
						echo "Value cannot be below zero." . PHP_EOL;
					}
				} else {
					echo "Value cannot be below zero." . PHP_EOL;
				}
			} else {
				echo "Value cannot be below zero." . PHP_EOL;
			}
			?>
		</main>
		<footer>
			<br>
			<br>
			<a href="group4-hr-fuel.html">Return to Fuel Reimbursement Calculation</a>
		</footer>
	</div>
</body>

</html>
