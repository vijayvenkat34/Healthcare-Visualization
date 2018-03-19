
<?php
require 'dbconnect.php';
$domain = $_GET['domain'];
require_once("process.php");
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
      <li><a href="districtwise.php?domain=<?php echo $domain?>">District wise</a></li>
      <li><a href="#">Subdistrict wise</a></li>
    </ul>
  </div>
</nav>
	<div class="container-fluid">
	<div class="row">
	<div class="col-md-2">
	
	<!--Fooooooooooooooooooooooooooooooooorrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm--------------------------------------------------------------------------------------------->
		<form action="statewise.php?domain=<?php echo $domain;?>" method="POST">  
		
		<h3>Select Year</h3> 
		<div class="form-group">
		<select class="form-control" name="formYear">
		<option>2016</option>
		</select>
		</div>
		
		
		<h3>Select Parameter</h3> 
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
	
		<h3>Select Type</h3> 
		<div class="form-group">
		<select class="form-control" id="B" name="formType">
		</select>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
	<div class="row">
		<div class="col-md-9">
			<div id="chart_div2"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12"><div id="linechart"></div></div>
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
			$sql = "select distinct(parameter) from $domain";
			$result = mysql_query($sql);
			
			while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
				
				$sql = "select type from $domain where parameter='{$row['parameter']}'";
				$sub_result = mysql_query($sql);
				
				$parameter = $row['parameter'];
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
	</script>
	
	
	<!---------------------------------------Google charts api javascript-------------------------------------------------------------------->
  <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});
	  
	   google.charts.load('current', {                                   ////changes here
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyAjiMYuGyhxoFibQfPbe4VQLP2FN4Cw1WI'
      });

      // Set a callback to run when the Google Visualization API is loaded.

	  google.charts.setOnLoadCallback(drawChart3); ///changes here
	  //google.charts.setOnLoadCallback(lineChart);


	  
	    function drawChart3() {/////////////changes here

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'State');
        data.addColumn('number', 'Count');
		
		<?php
		if(isset($_POST['formYear']) && isset($_POST['formParameter']) && isset($_POST['formType'])){
			$year = $_POST['formYear'];
			$parameter = $_POST['formParameter'];
			$type = $_POST['formType'];
			
			mysql_select_db("state", $conn);
			$sql = "SELECT state,total from deaths_state where year='$year' and parameter='$parameter' and type = '$type';";
			$result = mysql_query($sql);
			
		}

        ?>
		

        data.addRows([
          <?php
          while( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
          {	
            echo "['".$row['state']."', ".$row['total']."],";
          }
         ?>
        ]);

        // Set chart options
        var options = {'title':'<?php echo $_POST['formParameter']; ?>',
			region: 'IN',
		displayMode: 'regions',
		resolution: 'provinces'
         };

        // Instantiate and draw our chart, passing in some options.
        var chart3 = new google.visualization.GeoChart(document.getElementById('chart_div2'));
        chart3.draw(data, options);
      }
	  
/* 	  	    function lineChart() {


			<?php
			mysql_select_db("state", $conn);
			mysql_query("drop view if exists temp");
			$sql = "CREATE VIEW temp as select year,type,total from deaths_state where parameter='$parameter' order by year asc";
			
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
			var options = {'title':'<?php echo $_POST['formParameter'].' in India'?>'
			 };

			// Instantiate and draw our chart, passing in some options.
			var chart3 = new google.visualization.LineChart(document.getElementById('linechart'));
			chart3.draw(data, options);
      } */


    </script>
</html>