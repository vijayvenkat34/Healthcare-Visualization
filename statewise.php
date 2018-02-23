
<?php
require 'dbconnect.php';
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

  </head>

  <body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Healthcare</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="#">Overview</a></li>
	  <li class="active"><a href="#">State wise</a></li>
      <li><a href="#">District wise</a></li>
      <li><a href="#">Subdistrict wise</a></li>
    </ul>
  </div>
</nav>
	<div class="container-fluid">
	<div class="row">
	<div class="col-md-2">
		<form action="statewise.php" method="POST">  
		
		<h3>Select Year</h3> 
		<div class="form-group">
		<select class="form-control" name="formYear">
		<option>2016</option>
		</select>
		</div>
		
		<h3>Select State</h3> 
		<div class="form-group">
		<select class="form-control" name="formState">
		<option>Maharashtra</option>
		<option>Goa</option>
		</select>
		</div>
		
		<h3>Select Parameter</h3> 
		<div class="form-group">
		<select class="form-control" name="formParameter">
		<option>Maternal deaths (age 15-49 years) with the probable cause being Bleeding</option>
		</select>
		</div>
	  
		<h3>Select Type</h3> 
		<div class="form-group">
		<select class="form-control" name="formType">
		<option>15-49 yrs</option>
		</select>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
	<div class="col-md-9">
	<div class="container-fluid">
		<div class="col-md-12"><div id="chart_div"></div></div>
	</div><br><br>
	<div class="container-fluid">
		<div class="col-md-6"><div id="chart_div1"></div></div>
		<div class="col-md-6"></div>
	</div>
  </div>


	</div>
	</div>
  </body>

  <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Districts');
        data.addColumn('number', 'Count');

        <?php
		if(isset($_POST['formYear']) && isset($_POST['formState']) && isset($_POST['formParameter']) && isset($_POST['formType'])){
			$year = $_POST['formYear'];
			$state = $_POST['formState'];
			$parameter = $_POST['formParameter'];
			$type = $_POST['formType'];
			
			mysql_select_db("district", $conn);
			$sql = "select year,state,district,total from deaths_district where year='$year' and state='$state' and parameter='$parameter' and type='$type' order by total desc";
			$result = mysql_query($sql);
			
		}

        ?>

        data.addRows([
          <?php
			mysql_select_db("district", $conn);
			$sql = "select year,state,district,total from deaths_district where year='$year' and state='$state' and parameter='$parameter' and type='$type' order by total desc";
			$result = mysql_query($sql);
          while( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
          {	
            echo "['".$row['district']."', ".$row['total']."],";
          }
         ?>
        ]);

        // Set chart options
        var options = {'title':'<?php echo $_POST['formParameter']; ?>',
                        'is3D':true,};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      function drawChart2() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Districts');
        data.addColumn('number', 'Count');

        <?php
        mysql_select_db("district", $conn);
        $sql = "select year,state,district,total from deaths_district where year='$year' and state='$state' and parameter='$parameter' and type='$type' order by total desc";
        $result = mysql_query($sql);
        ?>

        data.addRows([
          <?php
          while( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
          {	
            echo "['".$row['district']."', ".$row['total']."],";
          }
         ?>
        ]);

        // Set chart options
        var options = {'title':'<?php echo $_POST['formParameter']; ?>'
         };

        // Instantiate and draw our chart, passing in some options.
        var chart2 = new google.visualization.PieChart(document.getElementById('chart_div1'));
        chart2.draw(data, options);
      }


    </script>
</html>