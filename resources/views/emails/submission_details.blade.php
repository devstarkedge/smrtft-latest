<?php
echo "<table border='1' style='border-collapse: collapse;'>";
			echo "<tr><td colspan='2' style='text-align:center;'><h2>Form Submission</h2></td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>First Name</h3></td><td style='padding:0 10px;'>$details->first_name</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Last Name</h3></td><td style='padding:0 10px;'>$details->last_name</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Tell us what you are looking to do</h3></td><td style='padding:0 10px;'>$details->purpose</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>How many people will be applying for this loan</h3></td><td style='padding:0 10px;'>$details->people</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Are there any guarantors on this loan application</h3></td><td style='padding:0 10px;'>$details->guarantors</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Phone</h3></td><td style='padding:0 10px;'>$details->phone</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Job Description</h3></td><td style='padding:0 10px;'>$details->job_description</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Annual Income</h3></td><td style='padding:0 10px;'>$details->annual_income</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Income Source</h3></td><td style='padding:0 10px;'>$details->income_source</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Loan Amount</h3></td><td style='padding:0 10px;'>$details->loan_amount</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Loan Term</h3></td><td style='padding:0 10px;'>$details->loan_term</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Property Detail</h3></td><td style='padding:0 10px;'>$details->property_detail</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Asset 1</h3></td><td style='padding:0 10px;'>$details->asset_1</td></tr>";
			echo "<tr><td style='padding:0 10px;'><h3>Asset 2</h3></td><td style='padding:0 10px;'>$details->asset_2</td></tr>";
			echo "</table>";
			
?>
