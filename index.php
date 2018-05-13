<html>
    <head>
        
        <link href="bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		
<!-- Add icon library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
		body {
		background-image: url("img/healthitlogo.png");
		background-size: cover;
		background-position:center;
		text-align:center;
		
		}
		.button {
		border-radius:10px;
		background-color: #337ab7; /*Green #4CAF50 */
		border: none;
		color: white;
		padding: 8px 25px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 15px;
		width: 250px;
		
		}
		
		.button:hover{
		background-color: #83B9EA;
		}
		</style>
    </head>
<body>
<p style="font-size:70px;margin-bottom:10px;"><b>Healthcare Data Visualization<i class="fa fa-heartbeat"></i></b></p><hr>
<p style="font-size:25px">Health-Care Data Visualization of every state of India. <br>Represented through <i class="fa fa-bar-chart"></i>, <i class="fa fa-pie-chart"></i>, <i class="fa fa-area-chart"></i>, <i class="fa fa-line-chart"></i>...</p>
<div class="container">
<p style="font-size:50px;margin-bottom:10px"><i class="fa fa-search"></i><b> Select Domain</b></p>



<p>&nbsp&nbsp<a href="tableau/deaths.php" class="button">REASON OF DEATHS</a>&nbsp&nbsp&nbsp&nbsp
<a href="tableau/childdiseases.php" class="button">CHILDHOOD DISEASES</a>&nbsp&nbsp</p>

<p>&nbsp&nbsp<a href="tableau/labtest.php" class="button">LAB TESTING</a>&nbsp&nbsp&nbsp&nbsp
<a href="tableau/childimmune.php" class="button">CHILD IMMUNIZATION</a>&nbsp&nbsp</p>

<p>&nbsp&nbsp<a href="tableau/pregencies.php" class="button">CHILD BIRTHS</a>&nbsp&nbsp&nbsp&nbsp
<a href="tableau/familyplanning.php" class="button">FAMILY PLANNING</a>&nbsp&nbsp</p>

<p><a href="download.php"><button style="padding: 8px 25px; "><i class="fa fa-cloud-download"></i> DOWNLOAD DATASETS</a></button>
</div>
</body>
</html>