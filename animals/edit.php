<!DOCTYPE HTML>
<html>
<head>
   <title>Edit  Basic Info</title>
   <?php include("../assets/css/styles-include.html"); ?>
</head>

<body>	
<div class="container-fluid">
	<div class="row">
		 <div class="col-lg-8 col-lg-push-3">
			<?php	
				//include database connection
				include '../libs/db_connect.php';

				$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
				
				if ($action == "update") {
					 try{		 
						  //write query
						  $query = "UPDATE Individuals 
									SET name = :name, dob = :dob, 
									species = :species, breed = :breed, color = :color, 
									fixed = :fixed, onFarm = :onFarm, lastUpdated = :lastUpdated, 
									notes = :notes, gender = :gender
									WHERE amiID = :amiID";

						  //prepare query for excecution
						  $stmt = $con->prepare($query);
				 
						  //bind the parameters
						  $stmt->bindParam(':amiID', $_POST['amiID']);
						  $stmt->bindParam(':name', $_POST['name']);
						  $stmt->bindParam(':dob', $_POST['dob']);
						  $stmt->bindParam(':gender', $_POST['gender']);
						  $stmt->bindParam(':breed', $_POST['breed']);
						  $stmt->bindParam(':color', $_POST['color']);
						  $stmt->bindParam(':fixed', $_POST['fixedRadio']);
						  $stmt->bindParam(':onFarm', $_POST['onFarmRadio']);
						  $stmt->bindParam(':species', $_POST['species']);
						  $stmt->bindParam(':lastUpdated', $_POST['lastUpdated']);	
						  $stmt->bindParam(':notes', $_POST['notes']);			 
								
						  // Execute the query
						  if($stmt->execute()) {
								echo '<div class="panel panel-success">
									<div class="panel-heading">
										<h3 class="panel-title">Updated!</h3>
									</div>
									<div class="panel-body">
										The animal\'s record was successfully updated.
									</div>
								</div>';
						  } else {
								die('<div class="panel panel-danger">
									<div class="panel-heading">
										<h3 class="panel-title">Alas...</h3>
									</div>
									<div class="panel-body">
										The application was unable to update the record.
									</div>
								</div>');
						  }
							
					 } catch(PDOException $exception){ //to handle error
						  echo "Error: " . $exception->getMessage();
					 }
				} // end update action
				 
				try {				 
					//get the info
					$query = "SELECT * FROM Individuals WHERE amiID = ?";
					$stmt = $con->prepare( $query );
					$stmt->bindParam(1, $_GET['amiID']);
					
					//execute our query
					$stmt->execute();
					
					//store retrieved row to a variable
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					
					//values to fill up our form
					$amiID = $row['amiID'];
					$name = $row['name'];
					$dob = $row['dob'];
					$gender = $row['gender'];
					$breed = $row['breed'];
					$color = $row['color'];
					$fixed = $row['fixed'];
					$onFarm = $row['onFarm'];
					$species = $row['species'];
					$lastUpdated = $row['lastUpdated'];
					$notes = $row['notes'];
					  
				} catch(PDOException $exception){ //to handle error
					 echo "Error: " . $exception->getMessage();
				}
			?>					
		
			<h1>Update <?php echo $name ?>'s Record</h1>
			
			<form action='#' method='post' id="editForm">
				<!-- so that we could identify what record is to be updated -->
				<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 
				<input type="hidden" name="speciesOriginal" id="speciesOriginal" value="<?php echo $species ?>" />	
				
				<div class="row">
					<div class="col-sm-6">
						<label for="name">Name</label>
						<input type='text' name='name' id="name" class="form-control" value='<?php echo $name; ?>' />
					</div>
					<div class="col-sm-6">
						<label for="species">Species</label>					
						<?php include '../inc/species.php' ?>
					</div>
				</div>
				<div class="row">					
					<div class="col-sm-6">
						<label for="dob">Date of Birth <small>yyyy-mm-dd</small></label>
						<input type='text' name='dob' class="form-control js-date datepicker" value='<?php echo $dob;	 ?>'	/>	
					</div>
					<div class="col-sm-6">
						<label>Gender</label>
						<input type='hidden' name='gender' id="gender" value='<?php echo $gender;  ?>' />
							<label class="inlineBlock marginRight">
							<input type="radio" name="gender" value="0" class="female" /> 
							Female</label>
						<label class="inlineBlock">
							<input type="radio" name="gender" value="1" class="male" /> 
							Male</label> 
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-6">
						<label for="breed">Breed</label>
						<input type='text' name='breed' class="form-control" value='<?php echo $breed; ?>' />
					</div>
					<div class="col-sm-6">
						<label>Fixed?</label>
						<input type='hidden' name='fixed' id="fixed" value='<?php echo $fixed; ?>' />
						<label class="marginRight inlineBlock">
							<input type="radio" name="fixedRadio" value="0" class="fixedFalse" /> 
							No</label>
						<label class="inlineBlock">
							<input type="radio" name="fixedRadio" value="1" class="fixedTrue" /> 
							Yes</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label for="color">Color(s)</label>
						<input type='text' name='color' class="form-control" value='<?php echo $color; ?>' />
					</div>
					<div class="col-sm-6">
						<label for="onFarm">On Farm?</label>
						<input type='hidden' name='onFarm' id="onFarm" value='<?php echo $onFarm; ?>' />
						<label class="marginRight inlineBlock">	
							<input type="radio" name="onFarmRadio" value="0" class="onFarmFalse"	 /> 
							No</label>
						<label class="inlineBlock">
							<input type="radio" name="onFarmRadio" value="1" class="onFarmTrue" /> 
							Yes</label>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<label for="notes">Notes</label>
						<textarea name="notes" class="form-control"><?php echo $notes ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<?php	
							$today = date('Y-m-d');
							echo "<input type='hidden' name='lastUpdated' value=$today />"; 
						?> 
						<input type='hidden' name='action' value='update' />
						<button type="submit" class="btn btn-primary" title="Click or press Enter to save">
							<i class="fa fa-floppy-o marginRightSm"></i>Save Changes
						</button>
						<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left"><i class="fa fa-info-circle margin-right-small"></i><?php echo $name ?>'s Main Page</a>
					</div>
				</div>
			</form>
      </div> <!-- /main column -->
		
		<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
			<?php include '../inc/sidebar.php'; ?>
		</div> <!-- /sidebar -->
	</div>
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?> 

<script type="text/javascript">
$(document).ready(function () {

	//match original value to select list value and set that one as selected
	var speciesOriginal = $('#speciesOriginal').val();
	$('#species option').each(function () {
		if ( $(this).val() == speciesOriginal ) {
			$(this).prop('selected', true);
		}
	});

	// get values and check related radio button
	var originalGender = $('#gender').val();
	var originalFixed = $('#fixed').val();
	var originalOnFarm = $('#onFarm').val();
	var originalActiveInjury = $('#activeInjury').val();
	
	if (originalGender == '0') 
		{ $('.female').prop('checked', true); }
		else { $('.male').prop('checked', true); }
		
	if (originalFixed == '0') 
		{ $('.fixedFalse').prop('checked', true); }
		else { $('.fixedTrue').prop('checked', true); }
		
	if (originalOnFarm == '0') 
		{ $('.onFarmFalse').prop('checked', true); }
		else { $('.onFarmTrue').prop('checked', true); }
	
}); //end document ready
</script>

</body>
</html>