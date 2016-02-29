<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit a Weight Record</title>
		<?php include("../assets/css/styles-include.html"); ?>
    </head>
<body>	
<div class="row">
	<div class="col-lg-8 main col-lg-push-3">
		<?php
			//include database connection
			include '../libs/db_connect.php';
			
			$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
			
			if ($action == "update") {
			    try {
			        //write query
			        $query = "UPDATE Weight 
			                  SET amiID = :amiID, weightDate = :weightDate, weight = :weight
			                  WHERE weightID = :weightID";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':weightID', $_POST['weightID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':weightDate', $_POST['weightDate']);
			        $stmt->bindParam(':weight', $_POST['weight']);
	         
			         	
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The weight record was successfully updated.
			            	</div>
			            </div>';
			        } else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the weight record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception){ //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			} // end update action
			 
			try {			 
			    //get the info
			    $query = "SELECT * FROM Weight 			    
			    JOIN Individuals 
			    ON Weight.amiID = Individuals.amiID
			    WHERE weightID = ?";
			    
			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['weightID']);
			    $stmt->execute();
			     
			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			     
			    //values to fill up our form
			    $weightID = $row['weightID'];
			    $amiID = $row['amiID'];
			    $weightDate = $row['weightDate'];
			    $weight = $row['weight'];
			    $name = $row['name'];
			     
			} catch(PDOException $exception){ //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>					
	
      <h1>Update <?php echo $name ?>'s Weight Record</h1>
		
		<form action='#' method='post' id="editWeight">
			<!-- so that we could identify what record is to be updated -->
			<input type='hidden' name='weightID' id='weightID' value='<?php echo $weightID ?>' /> 	
			<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 	
			<input type="hidden" name="name" id="name" value="<?php echo $name ?>" />
			<div class="row">
				<div class="col-md-6">
					<label for="weightDate">Weight Date</label>
					<input type='text' name='weightDate' class="datepicker form-control" value='<?php echo $weightDate; ?>' />
				</div>					
				<div class="col-md-6">
					<label for="trimDue">Weight</label>
					<input type='text' name='weight' class='form-control' value='<?php echo $weight;  ?>' />	
				</div>
			</div>	

			<div class="row">
				<div class="col-sm-12">	
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-pencil marginRightSm"></i>Save Changes
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left">
						<i class="fa fa-tachometer margin-right-small"></i>Weight Main Page
					</a>
				</div>
			</div>
		</form>
	
	</div> <!-- /main column -->	
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div> <!-- /sidebar -->
</div>

<!-- ************* Scripts ************* -->

<?php include("../js/js-include.html"); ?> 

<script type="text/javascript">
$(document).ready(function () {		
	
	$('#editWeight').foundation({bindings:'events'});

}); //end document ready
</script>

</body>
</html>