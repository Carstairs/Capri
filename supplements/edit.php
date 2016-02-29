<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit a Supplement Record</title>
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
			        $query = "UPDATE Supplements 
			                  SET amiID = :amiID, suppDate = :suppDate, suppDesc = :suppDesc, suppDue = :suppDue
			                  WHERE suppID = :suppID";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':suppID', $_POST['suppID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':suppDate', $_POST['suppDate']);
			        $stmt->bindParam(':suppDesc', $_POST['suppDesc']);
			        $stmt->bindParam(':suppDue', $_POST['suppDue']);
	         
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The supplement record was successfully updated.
			            	</div>
			            </div>';
			        } 
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the supplement record.
			            	</div>
			            </div>');
			        }
			         
			    } 
			    catch(PDOException $exception) { //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			} // end update action
			 
			try {			 
			    //get the info
			    $query = "SELECT * FROM Supplements 			    
			    JOIN Individuals 
			    ON Supplements.amiID = Individuals.amiID
			    WHERE suppID = ?";
			    
			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['suppID']);
			    $stmt->execute();
			     
			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			     
			    //values to fill up our form
			    $suppID = $row['suppID'];
			    $amiID = $row['amiID'];
			    $suppDate = $row['suppDate'];
			    $suppDesc = $row['suppDesc'];
			    $suppDue = $row['suppDue'];
			    $name = $row['name'];
			     
			} 
			catch(PDOException $exception){ //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>					
	
		<h1>Update <?php echo $name ?>'s Supplement Record</h1>
				
		<form action='#' method='post' id="editSupp">
			<!-- so that we could identify what record is to be updated -->
			<input type='hidden' name='suppID' id='suppID' value='<?php echo $suppID ?>' /> 	
			<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 	
			<input type="hidden" name="name" id="name" value="<?php echo $name ?>" />

			<div class="row">
				<div class="col-md-6">
					<label for="suppDate">Supplement Date</label>
					<input type='text' name='suppDate' class="datepicker suppDate form-control" value='<?php echo $suppDate; ?>' />
				</div>					
				<div class="col-md-6">
					<label for="suppDue">Supplement Due</label>
					<input type='text' name='suppDue' class='datepicker js-date suppDue form-control' value='<?php echo $suppDue;  ?>' />	
				</div>
			</div>	
			
			<div class="row">
				<div class="col-sm-12">
					<label for="suppDesc">Supplement Description</label>
					<input type="text" name="suppDesc" class="form-control" value="<?php echo $suppDesc ?>" />
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">	
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save Changes
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left">
						<i class="fa fa-eyedropper margin-right-small"></i>Supplements Main Page
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

<?php include("../assets/js/js-include.html"); ?>


</body>
</html>