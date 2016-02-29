<!DOCTYPE HTML>
<html>
    <head>
      <title>Edit a Procedures</title>
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
			    try{

			        //write query
			        $query = "UPDATE Procedures
			                  SET amiID = :amiID, procDate = :procDate, procDesc = :procDesc,
			                  procTxPlan = :procTxPlan, procTxNotes = :procTxNotes,
			                  procOutcome = :procOutcome, procPregDuring = :procPregDuring
			                  WHERE procID = :procID";

			        //prepare query for excecution
			        $stmt = $con->prepare($query);

			        //bind the parameters
			        $stmt->bindParam(':procID', $_POST['procID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':procDate', $_POST['procDate']);
			        $stmt->bindParam(':procPregDuring', $_POST['procPregDuring']);
			        $stmt->bindParam(':procDesc', $_POST['procDesc']);
			        $stmt->bindParam(':procTxPlan', $_POST['procTxPlan']);
			        $stmt->bindParam(':procTxNotes', $_POST['procTxNotes']);
			        $stmt->bindParam(':procOutcome', $_POST['procOutcome']);

			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The procedure was successfully updated.
			            	</div>
			            </div>';
			        } else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the procedure record.
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
			    $query = "SELECT *
			    	FROM Procedures
			    	JOIN Individuals
			    	ON Procedures.amiID = Individuals.amiID
			    	WHERE procID=?";

			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['procID']);

			    //execute our query
			    $stmt->execute();

			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);

			    //values to fill up our form
			    $procID = $row['procID'];
			    $amiID = $row['amiID'];
			    $name = $row['name'];
			    $procDate = $row['procDate'];
			    $procDesc = $row['procDesc'];
			    $procTxPlan = $row['procTxPlan'];
			    $procTxNotes = $row['procTxNotes'];
			    $procOutcome = $row['procOutcome'];
			    $procPregDuring = $row['procPregDuring'];
			}
			catch(PDOException $exception) { //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>

		<h1>Update <?php echo $name ?>'s Procedure</h1>

		<form action='#' method='post' id="editProc" data-abide>

			<input type="hidden" name="procID" value="<?php echo $procID ?>" />
			<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' />

			<div class="row">
				<div class="col-md-6">
					<label for="procDate">Procedure Date</label>
					<input type='text' name='procDate' class="datepicker js-date form-control" value="<?php echo $procDate ?>" />
				</div>
				<div class="col-md-6 inline">
					<div id="pregOptions" style="display: none;">
						<label for="procPregDuring">Pregnant During Procedure?</label>
						<input type="hidden" name="progPregOriginal" id="progPregOriginal" value="<?php echo $procPregDuring ?>" />

						<label class="inlineBlock marginRight">
							<input type="radio" name="procPregDuring" class="pregNo" value="0" /> No
						</label>
						<label class="inlineBlock">
							<input type="radio" name="procPregDuring" class="pregYes" value="1" /> Yes
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="procDesc">Procedure Description</label>
					<input type="text" name="procDesc" class="form-control" value="<?php echo $procDesc ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<label for="procTxPlan">Treatment Plan</label>
					<textarea rows="8" name="procTxPlan" class="form-control height-md"><?php echo $procTxPlan ?></textarea>
				</div>
				<div class="col-md-6">
					<label for="procTxNotes">Treatment Notes</label>
					<textarea rows="8" name="procTxNotes" class="form-control height-md"><?php echo $procTxNotes ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for="procOutcome">Outcome</label>
					<textarea rows="3" name="procOutcome" class="form-control height-sm"><?php echo $procOutcome ?></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save Changes
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left">
						<i class="fa fa-ambulance margin-right-small"></i>Procedures Main Page
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
      	//show hide preg options based on gender
		animalGender = $('#gender').val();
		if (animalGender === "0") {
			$('#pregOptions').show();
		}

		//set pregnancy radio
		var origPregValue = $("#progPregOriginal").val();
		if (origPregValue == "0") {
			$(".pregNo").prop("checked", true);
		} else {
			$(".pregYes").prop("checked", true);
		}


   });
</script>

</body>
</html>