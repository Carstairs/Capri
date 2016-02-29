<!DOCTYPE HTML>
<html>

<head>
    <title>Add a New Injury or Illness</title>
    <?php include("../assets/css/styles-include.html"); ?>
</head>

<body>
<div class="row">
	<div class="main col-lg-8 end col-lg-push-3">
		<?php
			// get the amiID from the URL
			$amiID = $_GET['amiID'];
			
			$action = isset($_POST['action']) ? $_POST['action'] : "";
			 
			if ($action == 'create') {
			    //include database connection
			    include '../libs/db_connect.php';
			 
			    try {     
			        //write query
			        $query = "INSERT INTO Injury
		        				SET amiID = :amiID, injBegan = :injBegan, 
		        				injEnd = :injEnd, injDesc = :injDesc, 
		        				injTx = :injTx, injOutcome = :injOutcome, injPregDuring = :injPregDuring";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        //this is the first question mark
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':injBegan', $_POST['injBegan']);
			        $stmt->bindParam(':injEnd', $_POST['injEnd']);
			        $stmt->bindParam(':injDesc', $_POST['injDesc']);
			        $stmt->bindParam(':injTx', $_POST['injTx']);
			        $stmt->bindParam(':injOutcome', $_POST['injOutcome']);
			        $stmt->bindParam(':injPregDuring', $_POST['injPregDuring']);
			 
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div id="success-panel" class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Added!</h3>
								</div>
								<div class="panel-body">
									The new injury record was successfully saved.
								</div>
							</div>';
			        } 
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to save the new injury record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception){ //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			}
		?>
		<h1 id="top">Add A New Injury or Illness</h1>
		<form action='#' method='post' id='addInjury'>
			<input type="hidden" name="amiID" value="<?php echo $amiID ?>" />
			
			<div class="row">
				<div class="col-md-4">
					<label for="injBegan">Injury Began <small>yyyy-mm-dd</small></label>
					<input type='text' name='injBegan' class="datepicker form-control" />
				</div>
				<div class="col-md-4">
					<label for="injEnd">Injury End <small>yyyy-mm-dd</small></label>
					<input type="text" name="injEnd" class="datepicker form-control" />
				</div>
				<div class="col-md-4">
					<div id="pregDuringInputs" style="display: none;">						
						<label for="injPregDuring">Pregnant During Injury/Illness?</label>
						<label for="injPregDuring" class="inlineBlock fontNormal marginRight">
							<input type="radio" name="injPregDuring" value="0" checked /> No
						</label>
						<label for="injPregDuring" class="inlineBlock fontNormal">
							<input type="radio" name="injPregDuring" value="1" /> Yes
						</label>
						<?php include '../inc/sex.php'; ?>
					</div>
				</div>
			</div>	
			
			<div class="row">
				<div class="col-sm-12">
					<label for="injDesc">Injury Description</label>
					<textarea name="injDesc" rows="3" class="form-control"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="injTx">Injury Treatment</label>
					<textarea name="injTx" rows="5" class="form-control"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="injOutcome">Injury Outcome</label>
					<textarea name="injOutcome" rows="3" class="form-control"></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='create' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save New Injury
					</button>
					<a href='index.php?amiID=<?php echo $amiID ?>' class="border-left pad-left margin-left">
						<i class="fa fa-wheelchair margin-right-small"></i>Injuries Main Page
					</a>
				</div>
			</div>
		</form>
	</div>		
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div> <!-- /sidebar -->
</div> <!-- end row -->

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?>

<script type="text/javascript">	 
$(document).ready(function () {
	
	animalSex = $('#gender').val();
	if (animalSex == "0") {
		$('#pregDuringInputs').show();
	}
	 
});
</script>

</body>
</html>