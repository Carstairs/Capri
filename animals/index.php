<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $name ?>'s Overview</title>
        <?php include("../assets/css/styles-include.html"); ?>
    </head>
<body>
<div class="container-fluid">
<div class="row">
	<div class="main col-lg-8 end col-lg-push-3">		
		<?php
			
			//include database connection
			include '../libs/db_connect.php';
			
			$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
			 
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
			    $species = $row['species'];				    
			    $breed = $row['breed'];
			    $color = $row['color'];
			    $fixed = $row['fixed'];
			    $onFarm = $row['onFarm'];
			    $lastUpdated = $row['lastUpdated'];
			    $notes = $row['notes'];
			     
			} catch(PDOException $exception){ //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>	
		
		<h1><?php echo $name ?>'s Information</h1>
		<!-- so that we could identify what record is to be updated -->
		<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' />
		 	
		<div class="row">
			<div class="col-sm-6">
				<label for="name">Name</label>
				<?php echo $name; ?>
			</div>
			<div class="col-sm-6">
				<label>Species</label>
				<?php echo $species ?>
			</div>
		</div>
		<div class="row">					
			<div class="col-sm-6">
				<label for="dob">Date of Birth</label>
				<span class="js-date"><?php echo $dob;  ?></span>
			</div>
			<div class="col-sm-6">
				<label>Gender</label>
				<input type='hidden' name='gender' id='gender' value='<?php echo $gender ?>' />
				<span id="genderText"></span>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-6">
				<label for="breed">Breed</label>
				<?php echo $breed; ?>
			</div>
			<div class="col-sm-6">
				<label>Spayed/Neutered</label>
				<span class="fixedText"></span>
				<input type='hidden' name='fixed' id="fixed" value='<?php echo $fixed; ?>' />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label for="color">Color(s)</label>
				<?php echo $color; ?>
			</div>
			<div class="col-sm-6">
				<label for="onFarm">On Farm?</label>
				<input type='hidden' name='onFarm' id="onFarm" value='<?php echo $onFarm; ?>' />
				<span class="onFarmText"></span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label for="notes">Notes</label>
				<?php echo $notes ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<hr />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<a href="/animals/edit.php?amiID=<?php echo $amiID ?>" class="btn btn-primary tipster" title="Make changes to <?php echo $name ?>'s basic information">
					<i class="fa fa-pencil"></i> Edit Record
				</a>
			</div>
		</div>
	</div>	
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div>
</div>
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?> 

<script type='text/javascript'>
   $(document).ready(function () {
   
	//convert booleans to text
   	if ($('#activeInjury').val() == '0'){ 
		$('.injury').text('No'); }
   	else { 
		$('.injury').text('Yes'); }
   
   	if ($('#fixed').val() == '0') { 
		$('.fixedText').text('No'); }
   	else { 
		$('.fixedText').text('Yes'); }
   
   	if ($('#onFarm').val() == '0') { 
		$('.onFarmText').text('No'); }
   	else { 
		$('.onFarmText').text('Yes'); }
	   
	if ($("#gender").val() === '0') { 
		$('#genderText').text("Female"); } 
	else { 
		$('#genderText').text("Male"); }
		
   
   }); //end document ready

</script>

</body>
</html>
