
<?php
require 'dbconnect.php';
$domain = $_GET['domain'];
require_once("process.php");
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	

  </head>

  <body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Healthcare</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="tableau/<?php echo $domain; ?>.php">Overview</a></li>
	  <li><a href="statewise.php?domain=<?php echo $domain?>">State wise</a></li>
      <li class="active"><a href="districtwise.php?domain=<?php echo $domain?>">District wise</a></li>
      <li><a href="subdistrictwise.php?domain=<?php echo $domain?>">Subdistrict wise</a></li>
    </ul>
  </div>
</nav>
	<div class="container-fluid">
	<div class="row">
	<div class="col-md-2" id="form">
	
	<!--Fooooooooooooooooooooooooooooooooorrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm--------------------------------------------------------------------------------------------->
		<form action="districtwise.php?domain=<?php echo $domain;?>" method="POST">  
		<div class="panel panel-primary">
		<div class="panel-heading"><h3>Options</h3></div>
		<div class="panel-body" id="form">
		<h4>Select Year</h4> 
		<div class="form-group">
		<select class="form-control" name="formYear">
			<?php
			$yearArray = ['2016','2015','2014','2013','2012','2011','2010'];
			if(isset($_POST['formYear'])){
				
				foreach($yearArray as $y){
					if($_POST['formYear'] == $y){
						echo "<option selected>".$y."</option>";
					}else{
						echo "<option>".$y."</option>";
					}
				}
			}else{
				echo "<option selected>2016</option>
						<option>2015</option>
						<option>2014</option>
						<option>2013</option>
						<option>2012</option>
						<option>2011</option><
						option>2010</option>";
			}
			?>
		</select>
		</div>
		
		<h4>Select State</h4> 
		<div class="form-group">
		<select class="form-control" name="formState">
		<?php
			$str = file_get_contents('content.json');
			$json = json_decode($str, true);
			
			foreach($json['states'] as $s){
				
				if(isset($_POST['formState'])){
					if($_POST['formState'] == $s['name']){
						
						echo "<option selected>".$s['name']."</option>";
					}else{
						echo "<option>".$s['name']."</option>";
					}
				}else{
					echo "<option>".$s['name']."</option>";
				}
			}
		?>
		</select>
		</div>
		
		<h4>Select Parameter</h4> 
		<div class="form-group">
		<select class="form-control" id="A" name="formParameter">
		
		<!--print parameter in dropdown dynamically from process.php-->
		<?php
			foreach($parameterArray as $i){
				if(isset($_POST['formParameter'])){
					$formParameter = $_POST['formParameter'];
					
					if($i == $formParameter)
						echo "<option selected>".$i."</option>";
					else
						echo "<option>".$i."</option>";
				}
				
				else
					echo "<option>".$i."</option>";
			}
		?>
		
		</select>
		</div>
		
		<!--select type based on parameter in dropdown dynamically logic in script -- custom script ---->
	
		<h4>Select Type</h4> 
		<div class="form-group">
		<select class="form-control" id="B" name="formType">
		</select>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
		</div>
		</div>
		</form>
	</div>
	<div class="col-md-9">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				
				<div class="panel-body"><div id="chart_div"></div></div>
			</div>
		</div>
	</div>
	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-primary">
				
				<div class="panel-body"><div id="linechart"></div></div>
		</div>
		</div>
	</div>
	<div class="row">

			<div class="col-md-6">
					<div class="panel panel-primary">
				<div class="panel-body"><div id="chart_div1"></div></div>
			</div>
		</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
				<div class="panel-heading"><h3>Top Parameter in 
				<?php 
					if(isset($_POST['formState']) && isset($_POST['formYear'])) {
						echo $_POST['formState'].' in '.$_POST['formYear'];
					}
				?>
				</h3></div>
				<div class="panel-body">
				
				<?php
				if(isset($_POST['formYear'])){
					
					$year = $_POST['formYear'];
					$state = $_POST['formState'];
					
					mysql_select_db("state", $conn);
					
					$sql = "select parameter,type,total from ".$domain."_state where year=$year and state='$state' order by total desc";
				
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
						echo '<h4>'.$row['parameter'].'</h4>';
						//echo '<h4>Range - '.$row['type'].'</h4>';
						
						echo '<h4>Value - '.number_format($row['total']).'</h4>';
						
						break;
					}
				}	
				?>
				</div>
			</div>
		</div>
		
	</div>



	</div>
	</div>
	</div>
  </body>


	  	<!---------------------------------------custom javascript-------------------------------------------------------------------->
	<script type="text/javascript">

	
	(function() {

  var bOptions = {
	  
	  <?php
	  /////modify this part with array
	  		mysql_select_db("frontend", $conn);
			//$sql = "select distinct(parameter) from $domain";
			//$result = mysql_query($sql);
			
			foreach($parameterArray as $i){
				
				$sql = "select type from $domain where parameter='{$i}'";
				$sub_result = mysql_query($sql);
				
				$parameter = $i;
				echo "\"$parameter\":[";
					while($sub_row = mysql_fetch_array($sub_result,MYSQL_ASSOC)){
						
						$type = $sub_row['type'];
						echo "\"$type\",";
					}
			echo "],";	
			}
	  ?>

  };

  var A = document.getElementById('A');
  var B = document.getElementById('B');

  A.onchange = function() {
    //clear out B
    B.length = 0;
    //get the selected value from A
    var _val = this.options[this.selectedIndex].value;
    //loop through bOption at the selected value
    for (var i in bOptions[_val]) {
      //create option tag
      var op = document.createElement('option');
      //set its value
      op.value = bOptions[_val][i];
      //set the display label
      op.text = bOptions[_val][i];
      //append it to B
      B.appendChild(op);
    }
  };
  // to update B on load
  A.onchange();

})();

//save the type
document.getElementById('B').options[<?php
if(isset($_POST['formParameter']) && isset($_POST['formType'])){
		mysql_select_db("frontend", $conn);
			$sql = "select type from $domain where parameter ='{$_POST['formParameter']}'";
			$result = mysql_query($sql);
			
			$count = 0;
			while($row = mysql_fetch_array($result,MYSQL_ASSOC) ){
				if($row['type'] == $_POST['formType']){
					echo $count;
				}
				$count++;
			}
}else{
	echo "0";
}

			
 ?>
 ].selected = true;
 
//TODO save state,year,district,subdistrict

 
	</script>
	
	
	<!---------------------------------------Google charts api javascript-------------------------------------------------------------------->
  <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});
	  

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart2);
	  google.charts.setOnLoadCallback(lineChart);

      // Callback that creates and populates a data table,
      // instantiates the chart, passes in the data and
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
			
			//mysql_select_db("district", $conn);
			//$sql = "select year,state,district,total from deaths_district where year='$year' and state='$state' and parameter='$parameter' and type='$type' order by total desc";
			//$result = mysql_query($sql);
			
		}

        ?>

        data.addRows([
          <?php
			mysql_select_db("district", $conn);
			$sql = "select district,total from ".$domain."_district where year='$year' and state='$state' and parameter='$parameter' and type='$type' order by total desc limit 15";
			$result = mysql_query($sql);
          while( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
          {	
            echo "['".$row['district']."', ".$row['total']."],";
          }
         ?>
        ]);

        // Set chart options
        var options = {'title':'<?php echo 'Districts in '.$_POST['formState'].' ('.$_POST['formParameter'].') ('.$_POST['formType'].')'; ?>',
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
			$sql = "select district,total from ".$domain."_district where year='$year' and state='$state' and parameter='$parameter' and type='$type' order by total desc limit 10";
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
	  
	    function lineChart() {


			<?php
			mysql_select_db("state", $conn);
			mysql_query("drop view if exists temp");
			$sql = "CREATE VIEW temp as select year,type,total from ".$domain."_state where state='$state' and parameter='$parameter' order by year asc";
			
			$result_view = mysql_query($sql);
			
			$result_year = mysql_query("select distinct(year) from temp");
			$result_type = mysql_query("select distinct(type) from temp");
			
			
			
			$year = [];
			$i = 0;
			while( $row = mysql_fetch_array($result_year,MYSQL_ASSOC) )
			  {
				$year[$i++] = $row['year'];
			  }
			 
			$type = [];
			$i = 0;
			while( $row = mysql_fetch_array($result_type,MYSQL_ASSOC) )
			  {
				$type[$i++] = $row['type'];
			  }
				
			?>
			
			
			// Create the data table.
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Year');
			<?php
				foreach($type as $t){
					echo "data.addColumn('number', '$t');";
				}
			?>
			data.addRows([
			  <?php
	
				//if($row['total']!=0){
					//dont consider 0 values
				//	echo "['".$row['year']."', ".$row['total']."],";
				//}
				foreach($year as $y){
					echo "['".$y."',";
					foreach($type as $t){
						
						$sql = "select * from temp where year='$y' and type='$t'";
						$result = mysql_query($sql);
						while( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
							{
								echo $row['total'].",";
							}
						 
					}
					echo "],";
	
				}
			  
			 ?>
			]);

			// Set chart options
			var options = {'title':'<?php echo 'Trend of '.$_POST['formParameter'].' in '.$_POST['formState']; ?>',
				curveType: 'function'
			 };

			// Instantiate and draw our chart, passing in some options.
			var chart3 = new google.visualization.LineChart(document.getElementById('linechart'));
			chart3.draw(data, options);
      }
	  


    </script>
</html>