<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit a Record</title>
		<?php include("../assets/css/styles-include.html"); ?>
    </head>
<body>	
<div class="row">
	<div class="main col-lg-8 end col-lg-push-3">
		<?php
			
			//include database connection
			include '../libs/db_connect.php';
			
			$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
			
			if ($action=="update") {

			    try{     
			        //write query
			        $query = "UPDATE Injury 
			                  SET amiID = :amiID, injBegan = :injBegan, injEnd = :injEnd, 
			                    injDesc = :injDesc, injTx = :injTx, 
			                    injOutcome = :injOutcome, injPregDuring = :injPregDuring
			                  WHERE injID = :injID";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':injID', $_POST['injID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':injBegan', $_POST['injBegan']);
			        $stmt->bindParam(':injEnd', $_POST['injEnd']);
			        $stmt->bindParam(':injDesc', $_POST['injDesc']);
			        $stmt->bindParam(':injTx', $_POST['injTx']);
			        $stmt->bindParam(':injOutcome', $_POST['injOutcome']);
			        $stmt->bindParam(':injPregDuring', $_POST['injPregDuringRadio']);	         
			        
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The injury record was successfully updated.
			            	</div>
			            </div>';
			        } 
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the injury record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception){ //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			} // end update action
			 
			// initial display of the info 
			try {
			    //get the info
			    $query = "SELECT * FROM Injury 			    
			    JOIN Individuals 
			    ON Injury.amiID = Individuals.amiID
			    WHERE injID = ?";
			    
			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['injID']);
			     
			    //execute our query
			    $stmt->execute();
			     
			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			     
			    //values to fill up our form
			    $injID = $row['injID'];
			    $amiID = $row['amiID'];
			    $injBegan = $row['injBegan'];
			    $injEnd = $row['injEnd'];
			    $injDesc = $row['injDesc'];
			    $injTx = $row['injTx'];
			    $injOutcome = $row['injOutcome'];
			    $injPregDuring = $row['injPregDuring'];
			    $name = $row['name'];
			} 
			catch(PDOException $exception){ //to handle error
			    echo "Error: " . $exception->getMessage();
			}
			
			echo "<h1>Update ".$name."'s Injury Record</h1>";
		?>					
	
		<form action='#' method='post' id='editInjury'>
			<input type="hidden" name="injID" value="<?php echo $injID ?>" />
			<input type="hidden" name="amiID" value="<?php echo $amiID ?>" />
			<div class="row">
				<div class="col-md-4">
					<label for="injBegan">Injury Began <small>yyyy-mm-dd</small></label>
					<input type='text' value="<?php echo $injBegan ?>" name='injBegan' class="datepicker js-date form-control" />
				</div>
				<div class="col-md-4">
					<label for="injEnd">Injury End <small>yyyy-mm-dd</small></label>
					<input type="text" value="<?php echo $injEnd ?>" name="injEnd" class="datepicker js-date form-control" />
				</div>
				<div class="col-md-4">
					<div id="pregDuringInputs" style="display: none;">
						<label for="injPregDuring">Pregnant During Injury/Illness?</label>
						<input type="hidden" name="injPregDuring" id="injPregDuring" value="<?php echo $injPregDuring ?>" />
						
						<label for="injPregDuring" class="inlineBlock fontNormal marginRight">
							<input type="radio" class="injPregDuringRadioNo" name="injPregDuringRadio" value="0" /> No
						</label>
						<label for="injPregDuring" class="inlineBlock fontNormal">
							<input type="radio" class="injPregDuringRadioYes" name="injPregDuringRadio" value="1" /> Yes
						</label>
						<?php include '../inc/sex.php'; ?>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-12">
					<label for="injDesc">Injury Description</label>
					<textarea name="injDesc" rows="3" class="form-control"><?php echo $injDesc ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="injTx">Injury Treatment</label>
					<textarea name="injTx" rows="5" class="form-control"><?php echo $injTx ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="injOutcome">Injury Outcome</label>
					<textarea name="injOutcome" rows="3" class="form-control"><?php echo $injOutcome ?></textarea>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o"></i>Save Changes
					</button>
					<a href='index.php?amiID=<?php echo $amiID ?>' class="border-left pad-left margin-left">
						<i class="fa fa-wheelchair"></i>Injuries Main Page
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

<script type="text/javascript">
$(document).ready(function () {
	
	animalSex = $('#gender').val();
	if (animalSex == "0") {
		$('#pregDuringInputs').show();
	}

	// get values and check related radio button
	var originalpregDuring = $('#injPregDuring').val();
		
	if (originalpregDuring == '0') { 
		$('.injPregDuringRadioNo').prop('checked', true); 
	}
	else { 
		$('.injPregDuringRadioYes').prop('checked', true); 
	}

}); //end document ready
</script>

</body>
</html>