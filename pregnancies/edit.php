<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit a Pregnancy</title>
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
			        $query = "UPDATE Pregnancies 
			                  SET amiID = :amiID, 
				                  heatBeganDate = :heatBeganDate, 
				                  pregSire = :pregSire,
				                  pregBreedDate = :pregBreedDate, 
				                  pregResulted = :pregResulted,
				                  pregDueDate = :pregDueDate,
				                  pregBirthDate = :pregBirthDate, 
				                  pregKidsFemale = :pregKidsFemale,
				                  pregKidsMale = :pregKidsMale, 
				                  pregKidsPassed = :pregKidsPassed
			                  WHERE pregID = :pregID";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':pregID', $_POST['pregID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':heatBeganDate', $_POST['heatBeganDate']);
			        $stmt->bindParam(':pregSire', $_POST['pregSire']);
			        $stmt->bindParam(':pregBreedDate', $_POST['pregBreedDate']);
			        $stmt->bindParam(':pregResulted', $_POST['pregResulted']);
			        $stmt->bindParam(':pregDueDate', $_POST['pregDueDate']);
			        $stmt->bindParam(':pregBirthDate', $_POST['pregBirthDate']);
			        $stmt->bindParam(':pregKidsFemale', $_POST['pregKidsFemale']);
			        $stmt->bindParam(':pregKidsMale', $_POST['pregKidsMale']);
			        $stmt->bindParam(':pregKidsPassed', $_POST['pregKidsPassed']);	         
			         	
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The breeding and pregnancy record was successfully updated.
			            	</div>
			            </div>';
			        } else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the breeding and pregnancy record.
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
			    	FROM Pregnancies 
			    	JOIN Individuals 
			    	ON Pregnancies.amiID = Individuals.amiID 
			    	WHERE pregID=?";
			    	
			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['pregID']);
			     
			    //execute our query
			    $stmt->execute();
			     
			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			     
			    //values to fill up our form
			    $pregID = $row['pregID'];
			    $amiID = $row['amiID'];
			    $name = $row['name'];
			    $heatBeganDate = $row['heatBeganDate'];
			    $pregSire = $row['pregSire'];
			    $pregBreedDate = $row['pregBreedDate'];
			    $pregResulted = $row['pregResulted'];
			    $pregDueDate = $row['pregDueDate'];
			    $pregBirthDate = $row['pregBirthDate'];
			    $pregKidsFemale = $row['pregKidsFemale'];
			    $pregKidsMale = $row['pregKidsMale'];
			    $pregKidsPassed = $row['pregKidsPassed'];
			} 
			catch(PDOException $exception) { //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>					
		
		<h1>Update <?php echo $name ?>'s Pregnancy</h1>
		
		<form action='#' method='post' id="editPreg">
			<!-- so that we could identify what record is to be updated -->
			<input type='hidden' name='pregID' id='pregID' value='<?php echo $pregID ?>' />
			<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 	
			
			<div class="row">
				<div class="col-md-4">
					<label>Heat Began Date</label>
					<input type="text" name="heatBeganDate" class="datepicker js-date form-control" value="<?php echo $heatBeganDate ?>" />
				</div>
				<div class="col-md-4">
					<label for="dob">Sire</label>
					<input type='text' name='pregSire' class="form-control" value="<?php echo $pregSire ?>" />
				</div>
				<div class="col-md-4">
					<label for="pregResulted">Pregnancy Resulted</label>
					<label class="inlineBlock margin-right">
						<input type="radio" name="pregResulted" value="0" checked /> No
					</label>
					<label class="inlineBlock">
						<input type="radio" name="pregResulted" value="1" /> Yes
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<label for="name">Breed Date <small>yyyy-mm-dd</small></label>
					<input type='text' name='pregBreedDate' class='datepicker js-date form-control' value="<?php echo $pregBreedDate ?>" />					
				</div>
				<div class="col-md-4">
					<label for="pregDueDate">Due Date <small>yyyy-mm-dd</small></label>
					<input type="text" name="pregDueDate" class="datepicker js-date form-control" value="<?php echo $pregDueDate ?>" />
				</div>
				<div class="col-md-4">
					<label for="pregBirthDate">Birth Date <small>yyyy-mm-dd</small></label>
					<input type="text" name="pregBirthDate" class="datepicker js-date form-control" value="<?php echo $pregBirthDate ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<hr />
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<label for="pregKidsFemale">Female Offspring</label>
					<input type="hidden" name="pregFemaleOriginal" id="pregFemaleOriginal" value="<?php echo $pregKidsFemale ?>" />
					<select name="pregKidsFemale" id="pregKidsFemale" class="form-control">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="pregKidsMale">Male Offspring</label>
					<input type="hidden" name="pregMaleOriginal" id="pregMaleOriginal" value="<?php echo $pregKidsMale ?>" />
					<select name="pregKidsMale" id="pregKidsMale" class="form-control">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="pregKidsPassed">Offspring Passed Away</label>
					<input type="hidden" name="pregPassedOriginal" id="pregPassedOriginal" value="<?php echo $pregKidsPassed ?>" />
					<select name="pregKidsPassed" id="pregKidsPassed" class="form-control">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
			</div>
			
			<div class="row margin-top-xl">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save Changes
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>"  class="border-left pad-left margin-left">
						<i class="fa fa-female marginRightSm"></i>Pregnancies Main Page
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

	// get values and check related radio button
	var pregFemaleOriginal = $('#pregFemaleOriginal').val();
	var pregMaleOriginal = $('#pregMaleOriginal').val();
	var pregPassedOriginal = $('#pregPassedOriginal').val();

	//match original value to select list value and set that one as selected
	$('#pregKidsFemale option').each(function () {
		if ( $(this).val() == pregFemaleOriginal ) {
			$(this).prop('selected', true);
		}
	});
	$('#pregKidsMale option').each(function () {
		if ( $(this).val() == pregMaleOriginal ) {
			$(this).prop('selected', true);
		}
	});
	$('#pregKidsPassed option').each(function () {
		if ( $(this).val() == pregPassedOriginal ) {
			$(this).prop('selected', true);
		}
	});
	
}); //end document ready
</script>

</body>
</html>