<?php 

	$action = isset($_POST['action']) ? $_POST['action'] : "";
	
	if ($action == 'create') {
	    //include database connection
	    include 'libs/db_connect.php';
	 
	    try {     
	        //write query
	        $query = "INSERT INTO Vaccines 
	    				SET amiID = :amiID, vaxDate = :vaxDate, vaxDesc = :vaxDesc, vaxDue = :vaxDue";
	 		
	        //prepare query for excecution
	        $stmt = $con->prepare($query);
	 
	        //bind the parameters
	        $stmt->bindParam(':amiID', $_POST['amiID']);
	        $stmt->bindParam(':vaxDate', $_POST['vaxDate']);
	        $stmt->bindParam(':vaxDesc', $_POST['vaxDesc']);
	        $stmt->bindParam(':vaxDue', $_POST['vaxDue']);
	 
	        // Execute the query
	        if($stmt->execute()) {
	            echo '<div id="success-panel" class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">Added!</h3>
						</div>
						<div class="panel-body">
							The new vaccine record was successfully saved.
						</div>
					</div>';
	        } 
	        else {
	            die('<div class="panel panel-danger">
	            	<div class="panel-heading">
	            		<h3 class="panel-title">Alas...</h3>
	            	</div>
	            	<div class="panel-body">
	            		The application was unable to save the new vaccine record.
	            	</div>
	            </div>');
	        }
	         
	    }
	    catch(PDOException $exception) { //to handle error
	        echo "Error: " . $exception->getMessage();
	    }
	}	

?>