<!DOCTYPE HTML>
<html>
   <head>
       <title>Edit Hoof Trim</title>
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
			        $query = "UPDATE HoofTrims 
			                  SET amiID = :amiID, trimDate = :trimDate, trimDue = :trimDue
			                  WHERE trimID = :trimID";
			 
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':trimID', $_POST['trimID']);
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':trimDate', $_POST['trimDate']);
			        $stmt->bindParam(':trimDue', $_POST['trimDue']);
	         
			         	
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div class="panel panel-success">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Updated!</h3>
			            	</div>
			            	<div class="panel-body">
			            		The hoof trim was successfully updated.
			            	</div>
			            </div>';
			        } else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to update the hoof trim record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception){ //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			} // end update action
			 
			try {			 
			    //get the info
			    $query = "SELECT * FROM HoofTrims 			    
			    	JOIN Individuals 
			    	ON HoofTrims.amiID = Individuals.amiID
			    	WHERE trimID = ?";
			    
			    $stmt = $con->prepare( $query );
			    $stmt->bindParam(1, $_GET['trimID']);
			    $stmt->execute();
			     
			    //store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			     
			    //values to fill up our form
			    $trimID = $row['trimID'];
			    $amiID = $row['amiID'];
			    $trimDate = $row['trimDate'];
			    $trimDue = $row['trimDue'];
			    $name = $row['name'];
			     
			} catch(PDOException $exception){ //to handle error
			    echo "Error: " . $exception->getMessage();
			}
		?>					
		
		<div class="row">
			<h1>Update <?php echo $name ?>'s Hoof Trim</h1>
		</div>
		<form action='#' method='post' id="editHoofTrims">
			<!-- so that we could identify what record is to be updated -->
			<input type='hidden' name='trimID' id='trimID' value='<?php echo $trimID ?>' /> 	
			<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 	
			<input type="hidden" name="name" id="name" value="<?php echo $name ?>" />
			<div class="row">
				<div class="col-sm-6">
   				<div class="form-group">
   					<label for="trimDate">Trim Date</label>
   					<input type='text' name='trimDate' class="datepicker trimDate form-control" value="<?php echo $trimDate; ?>" />
   				</div>
				</div>					
				<div class="col-sm-6">
   				<div class="form-group">
   					<label for="trimDue">Next Trim Due</label>
   					<input type='text' name='trimDue' class='datepicker trimDue form-control' value="<?php echo $trimDue; ?>" />
   				</div>
				</div>
			</div>	

			<div class="row">
				<div class="col-sm-12">	
					<input type='hidden' name='action' value='update' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save Changes
					</button>
					<a href="index.php?amiID=<?php echo $amiID ?>" class="border-left pad-left margin-left">
						<i class="fa fa-paw margin-right-small"></i>Hoof Trims Main Page
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
   
   $(document).on("#editHoofTrims", "submit", function () {
      if ( $("#trimDate").val() === "" ) {
         alert("Please enter a trim date");
      }
   });

	if ( $('.trimDue').val() == "" || $('.trimDue').val() == "0000-00-00" ) {
		var $trimDate = $('.trimDate').val();
		
		var $dateArray = $trimDate.split('-');
		var $trimYear = $dateArray[0]; var $trimMonth = $dateArray[1]; var $trimDay = $dateArray[2];
		
		var $dueMonth = (parseInt($trimMonth)) + 1;
		
		// there's no month 14, flip it into next year
		if ($dueMonth > 13) {
			$dueMonth = $dueMonth - 12;
			var $dueYear = (parseInt($trimYear)) + 1;
			var $nextDue = $dueYear + "-" + $dueMonth + "-" + $trimDay;
		}
		else {	
			var $nextDue = $trimYear + "-" + $dueMonth + "-" + $trimDay;
		}
		$('.trimDue').val("");
		$('.trimDue').attr('placeholder', $nextDue);
	}		
	
}); //end document ready
</script>

</body>
</html>