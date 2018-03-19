<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp Back</a>
    </div>
	</div>
</nav>	
	
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading"><h2>Health performance datasets</h2><br>Last updated 15th March 2018</div>
	</div>
			<div class="row">
			<div class="col-md-3">
			<ul class="list-group">
			<li class="list-group-item disabled"><b>Total Size : 42MB</b></li>
			  <li class="list-group-item"><a href="download.php?domain=deaths"><span class="glyphicon glyphicon-file" aria-hidden="true"></span><b>Deaths</b></a></li>
			  <li class="list-group-item"><a href="download.php?domain=deaths"><span class="glyphicon glyphicon-file" aria-hidden="true"></span><b>Child Diseases</b></a></li>
			  <li class="list-group-item"><a href="download.php?domain=deaths"><span class="glyphicon glyphicon-file" aria-hidden="true"></span><b>Child Immunization</b></a></li>
			</ul>
			
			</div>
				<div class="col-md-9">
					<div>
						<?php
							if(isset($_GET['domain'])){
								echo '<h2>'.$_GET['domain'].'.csv &nbsp<a href="datasets/ChildDiseases-2016.csv" download><button type="submit" class="btn btn-primary">Download</button></a>';
								
							}
						?>
					</div>
				  <div class="table-responsive">
				 
					<?php
					//TODO get actual datasets from hadoop
						if(isset($_GET['domain'])){
							//$file = fopen("datasets/".$_GET['domain'].".csv","r");
							$file = fopen("datasets/ChildDiseases-2016.csv","r");

							echo '  <table class="table table-bordered" id="mytable">
									<thead>
									  <tr>
										<th>Year</th>
										<th>State</th>
										<th>District</th>
										<th>Subdistrict</th>
										<th>Parameter</th>
										<th>Type</th>
										<th>Total</th>
										
									  </tr>
									</thead>
									<tbody>';
									$i=0;
									while (($data = fgetcsv($file, 1000, ",")) !== FALSE  && $i!=10){

										echo '<tr>
												<td>'.$data[0].'</td>
												<td>'.$data[1].'</td>
												<td>'.$data[2].'</td>
												<td>'.$data[3].'</td>
												<td>'.$data[4].'</td>
												<td>'.$data[5].'</td>
												<td>'.$data[6].'</td>
											</tr>';
										$i++;
									}
									echo '</tbody>
										</table>';
									
						}
					?>
					</div>

			</div>
		</div>
	


</div>

</body>
</html>
