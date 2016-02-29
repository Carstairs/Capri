<!DOCTYPE HTML>
<html>
   <head>
       <title>Add a New Procedure</title>
       <?php include("../assets/css/styles-include.html"); ?>
   </head>

<body>
<div class="row">
	<div class="main col-lg-8 end col-lg-push-3">		
		
		<?php
			// set up a variable with the goatID the form can use
			$amiID = $_GET['amiID'];
				
			$action = isset($_POST['action']) ? $_POST['action'] : "";
			
			if ($action == 'create') {
			    //include database connection
			    include '../libs/db_connect.php';
			 
			    try {     
			        //write query
			        $query = "INSERT INTO Procedures 
		        				SET amiID = :amiID, procDate = :procDate, procDesc = :procDesc,
		        				procTxPlan = :procTxPlan, procTxNotes = :procTxNotes, 
		        				procOutcome = :procOutcome, procPregDuring = :procPregDuring";
			 		
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':procDate', $_POST['procDate']);
			        $stmt->bindParam(':procPregDuring', $_POST['procPregDuring']);
			        $stmt->bindParam(':procDesc', $_POST['procDesc']);
			        $stmt->bindParam(':procTxPlan', $_POST['procTxPlan']);
			        $stmt->bindParam(':procTxNotes', $_POST['procTxNotes']);
			        $stmt->bindParam(':procOutcome', $_POST['procOutcome']);
			 
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div id="success-panel" class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Added!</h3>
								</div>
								<div class="panel-body">
									The new procedure was successfully saved. 
								</div>
							</div>';
			        } 
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to save the new procedure record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception) { 
			        echo "Error: " . $exception->getMessage();
			    }
			}			 
		?>
		
		<h1>Add a New Procedure</h1>
		
		<form action='#' method='post' id='addPreg' data-abide>
		<input type="hidden" name="amiID" value="<?php echo $amiID ?>" />
		
			<div class="row">
				<div class="col-md-6">
					<label for="procDate">Procedure Date</label>
					<input type='text' name='procDate' class="datepicker js-date form-control" />
				</div>
				<div class="col-md-6 inline">
					<div id="pregOptions" style="display: none;">
						<label for="procPregDuring">Pregnant During Procedure?</label>
						<label class="inlineBlock marginRight">
							<input type="radio" name="procPregDuring" value="0" checked="true" /> No
						</label>
						<label class="inlineBlock">
							<input type="radio" name="procPregDuring" value="1" /> Yes
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="procDesc">Procedure Description</label>
					<input type="text" name="procDesc" value="" class="form-control" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<label for="procTxPlan">Treatment Plan</label>
					<textarea rows="8" name="procTxPlan" class="form-control height-md"></textarea>
				</div>
				<div class="col-sm-6 ">
					<label for="procTxNotes">Treatment Notes</label>
					<textarea rows="8" name="procTxNotes" class="form-control height-md"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="procOutcome">Outcome</label>
					<textarea rows="3" name="procOutcome" class="form-control height-sm"></textarea>
				</div>
			</div>			
			<div class="row">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='create' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save New Procedure
					</button>
					<a href='index.php?amiID=<?php echo $amiID ?>' class="border-left pad-left margin-left">
						<i class="fa fa-ambulance margin-right-small"></i>Procedures Main Page
					</a>
				</div>
			</div>
		</form>
	</div> 
	
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
			$('#pregOptions').show();
		}
	});
</script>


</body>
</html>