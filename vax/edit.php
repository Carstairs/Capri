<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit a Vaccine Record</title>
		<?php include("../assets/css/styles-include.html"); ?>
    </head>
<body>	
<div class="row">
	<div class="col-lg-8 col-lg-push-3">
		<?php
			//include database connection
			include '../libs/db_connect.php';
			
			$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
			
			if ($action == "update") {
			    try {
			        //write query
			        $query = "UPDATE Vaccines 
			                  SET amiID = :amiID, vaxDate = :vaxDate, vaxDesc = :vaxDesc, vaxDue = :vaxDue
			                  WHERE vaxID = :vaxID";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':vaxID', $_POST['vaxID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':vaxDate', $_POST['vaxDate']);
			        $stmt->bindParam(':vaxDesc', $_POST['vaxDesc']);
			        $stmt->bindParam(':vaxDue', $_POST['vaxDue']);
	         
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The vaccine record was successfully updated.
			            	</div>
			            </div>';
			        } else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the vaccine record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception){ //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			} // end update action
			 
			try {			 
			    //get the info
			    $query = "SELECT * FROM Vaccines 			    
			    JOIN Individuals 
			    ON Vaccines.amiID = Individuals.amiID
			    WHERE vaxID = ?";
			    
			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['vaxID']);
			    $stmt->execute();
			     
			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			     
			    //values to fill up our form
			    $vaxID = $row['vaxID'];
			    $amiID = $row['amiID'];
			    $vaxDate = $row['vaxDate'];
			    $vaxDesc = $row['vaxDesc'];
			    $vaxDue = $row['vaxDue'];
			    $name = $row['name'];
			     
			} catch(PDOException $exception){ //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>					
	
		<h1>Update <?php echo $name ?>'s Vaccine</h1>
				
		<form action='#' method='post' id="editVax">
			<!-- so that we could identify what record is to be updated -->
			<input type='hidden' name='vaxID' id='vaxID' value='<?php echo $vaxID ?>' /> 	
			<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 	
			<input type="hidden" name="name" id="name" value="<?php echo $name ?>" />

			<div class="row">
				<div class="col-lg-6">
					<label for="vaxDate">Vaccine Date</label>
					<input type='text' name='vaxDate' class="datepicker vaxDate form-control" value='<?php echo $vaxDate; ?>' />
				</div>					
				<div class="col-lg-6">
					<label for="vaxDue">Vaccine Due</label>
					<input type='text' name='vaxDue' class='datepicker vaxDue form-control' value="<?php echo $vaxDue;  ?>" />	
				</div>
			</div>	
			
			<div class="row">
				<div class="col-sm-12 columns">
					<label for="vaxDesc">Vaccine Description</label>
					<input type="text" name="vaxDesc" class="form-control" value="<?php echo $vaxDesc ?>" />
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">	
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tipster" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save Changes
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left">
						<i class="fa fa-medkit margin-right-small"></i>Vaccines Main Page
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

	if ( $('.vaxDue').val() == "" || $('.vaxDue').val() == "0000-00-00" ) {
		var $vaxDate = $('.vaxDate').val();
		
		var $dateArray = $vaxDate.split('-');
		var $vaxYear = $dateArray[0]; var $vaxMonth = $dateArray[1]; var $vaxDay = $dateArray[2];
		
		var $dueMonth = (parseInt($vaxMonth)) + 2;
		
		// there's no month 13, flip it into next year
		if ($dueMonth > 12) {
			$dueMonth = $dueMonth - 12;
			var $dueYear = (parseInt($vaxYear)) + 1;
			var $nextDue = $dueYear + "-" + $dueMonth + "-" + $vaxDay;
		}
		else {	
			var $nextDue = $vaxYear + "-" + $dueMonth + "-" + $vaxDay;
		}
		$('.vaxDue').val("");
		$('.vaxDue').attr('placeholder', $nextDue);
	}
	
	$('#editVax').foundation({bindings:'events'});
	
}); //end document ready
</script>

</body>
</html>