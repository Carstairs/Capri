<!DOCTYPE HTML>
<html>

<head>
    <title>Add a New Weight</title>
    <?php include("../assets/css/styles-include.html"); ?>
</head>

<body>
<div class="row">
	<div class="col-lg-8 main col-lg-push-3">
		<?php
			// set up a variable with the goatID the form can use
			$amiID = $_GET['amiID'];
			
			$action = isset($_POST['action']) ? $_POST['action'] : "";
			
			if ($action == 'create') {
			    //include database connection
			    include '../libs/db_connect.php';
			 
			    try {     
			        //write query
			        $query = "INSERT INTO Weight 
		        				SET amiID = ?, weightDate = ?, weight = ?";
			 		
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(1, $_POST['amiID']);
			        $stmt->bindParam(2, $_POST['weightDate']);
			        $stmt->bindParam(3, $_POST['weight']);
			 
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div id="success-panel" class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Added!</h3>
								</div>
								<div class="panel-body">
									The new weight record was successfully saved. 									
								</div>
							</div>';
			        } 
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to save the new weight record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception) { //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			}			 
		?>
		<h1>Add a New Weight Record</h1>
		
		<!--we have our html form here where information will be entered-->
		<form action='#' method='post' id='addWeight'>
			<div class="row">
				<div class="col-sm-6">
					<input type="hidden" name="amiID" value="<?php echo $amiID ?>" />
					<label for="weightDate">Weigh Date <small>yyyy-mm-dd</small></label>
					<input type='text' name='weightDate' class='datepicker form-control' />					
				</div>

				<div class="col-sm-6">
					<label for="weight">Weight</label>
					<input type='text' name='weight' class="form-control" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='create' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o"></i>Save New Weight
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left">
						<i class="fa fa-tachometer margin-right-small"></i>Weight Main Page
					</a>
				</div>
			</div>
		</form>
	</div> <!-- end container -->
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div> <!-- /sidebar -->
</div>

<!-- ************* Scripts ************* -->
<?php include("../assets/js/js-include.html"); ?>

<script type="text/javascript">	 
$(document).ready(function () {
	 

});
</script>

</body>
</html>