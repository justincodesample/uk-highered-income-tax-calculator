<!DOCTYPE html>
<html>
<head>
	<title>Simple Income Tax Calculator: OOP PHP JavaScript Demo</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
	<link href="https://theme.nms.kcl.ac.uk/css/app.css" rel="stylesheet">
	<script src="calculator.js"></script>
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="50">

	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
		<div class="container-fluid">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="#demo1">Calculate Your Income Tax & Take Home Pay</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#demo2">Income Tax & Take Home Pay Table</a>
				</li>
			</ul>
		</div>
	</nav>

<div id="demo1" class="container-fluid bg-primary text-white" style="padding:100px 20px;">
	<h1>Demo One: Calculate Your Income Tax & Take Home Pay</h1>
	<p>JavaScript Demo</p>
	<p>Enter your basic pay, lwa and pension contribution rate in the below field</p>
		<table class="table table-dark table-hover">
			<thead>
				<tr>
					<th>Basic Pay</th>
					<th>LWA</th>
					<th>Pension Contribution</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" id="basic" class="form-control form-control-sm" onchange="tax_calculator()" placeholder="basic salary"></td>
					<td><input type="text" id="lwa" class="form-control form-control-sm" onchange="tax_calculator()" placeholder="amount of london weighting allowance"></td>
					<td><input type="text" id="prate" class="form-control form-control-sm" onchange="tax_calculator()" placeholder="% contribute to your pension, for example, 0.06"></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-dark table-hover">
			<thead>
				<tr>
					<th>Basic Pay</th>
					<th>Include LWA</th>
					<th>Take Home</th>
					<th>Pension Paid</th>
					<th>Tax Paid</th>
					<th>NI Paid</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td id="basic_out">19333</td>
					<td id="include_lwa">4000</td>
					<td id="take_home">18636.17</td>
					<td id="pension_paid">1399.98</td>
					<td id="tax_paid">1872.60</td>
					<td id="ni_paid">1424.24</td>
				</tr>
			</tbody>
		</table>
</div>

<div id="demo2" class="container-fluid bg-secondary" style="padding:100px 20px;">
	<h1>Demo Two: Income Tax & Take Home Pay Table Of All Pay Grade</h1>
	<p>PHP Demo</p>
	<p>This demo parses data from a csv file and then calculate result using PHP backend. The frontend is generated using template and PHP.</p>
	<p>This calculator assumes pension contribution is 6% and £4000 LWA.</p>
	<div class="table-responsive">
		<table class="datatable table table-hover table-light table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Point</th>
					<th>Basic Pay</th>
					<th>Include LWA</th>
					<th>Take Home</th>
					<th>Pension Paid</th>
					<th>Tax Paid</th>
					<th>NI Paid</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$array_lenght = count($tax_objs);
					for ($i = 0; $i < $array_lenght; $i++) {
						echo "<tr>";
						echo "<td>$i</td>";
						echo "<td>";
							echo $tax_objs[$i]->get_income();
						echo "</td>";
						echo "<td>";
							echo $tax_objs[$i]->get_include_lwa();
						echo "</td>";
						echo "<td>";
							echo $tax_objs[$i]->get_take_home();
						echo "</td>";
						echo "<td>";
							echo $tax_objs[$i]->get_pension_paid();
						echo "</td>";
						echo "<td>";
							echo $tax_objs[$i]->get_tax_paid();
						echo "</td>";
						echo "<td>";
							echo $tax_objs[$i]->get_ni_paid();
						echo "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Point</th>
					<th>Basic Pay</th>
					<th>Include LWA</th>
					<th>Take Home</th>
					<th>Pension Paid</th>
					<th>Tax Paid</th>
					<th>NI Paid</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<footer id="footer" class="bg-light text-muted d-none d-md-block text-center">
	<ul class="list-unstyled">
		<li>Copyright &copy; 2022</li>
	</ul>
</footer>

</body>
</html>
