<!DOCTYPE HTML>
<html>
   <head>
       <title>Add a New Hoof Trim</title>
       <?php include("../assets/css/styles-include.html"); ?>       
   </head>

<body>
<div class="row">
	<div class="col-lg-8 main col-lg-push-3">

		<?php
			// set up a variable with the goatID the form can use
			$amiID = $_GET['amiID'];

			$action = isset($_POST['action']) ? $_POST['action'] : "";

			if ($action == 'create') {
			    //include database connection
			    include '../libs/db_connect.php';

			    try {
			        //write query
			        $query = "INSERT INTO HoofTrims
		        				SET amiID = ?, trimDate = ?, trimDue = ?";

			        //prepare query for excecution
			        $stmt = $con->prepare($query);

			        //bind the parameters
			        $stmt->bindParam(1, $_POST['amiID']);
			        $stmt->bindParam(2, $_POST['trimDate']);
			        $stmt->bindParam(3, $_POST['trimDue']);

			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div id="success-panel" class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Added!</h3>
								</div>
								<div class="panel-body">
									The new hoof trim was successfully saved.
								</div>
							</div>';
			        }
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to save the new hoof trim.
			            	</div>
			            </div>');
			        }

			    } catch(PDOException $exception) { //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			}
		?>

		<div class="row">
			<h1>Add a New Hoof Trim</h1>
		</div>

		<!--we have our html form here where information will be entered-->
		<form action='#' method='post' id="addHoofTrims">
   		<input type='hidden' name='amiID' id='amiID' value='<?php echo $amiID ?>' /> 	
			<input type="hidden" name="name" id="name" value="<?php echo $name ?>" />
			<div class="row">
				<div class="col-sm-6">
					<input type="hidden" name="amiID" value="<?php echo $amiID ?>" />
					<label for="name">Trim Date <small>yyyy-mm-dd</small></label>
					<input type='text' name='trimDate' id="trimDate" class='datepicker form-control' value=""  />
				</div>
				<div class="col-sm-6">
					<label for="dob">Trim Due <small>yyyy-mm-dd</small></label>
					<input type='text' name='trimDue' id="trimDue" class='datepicker form-control' value="" />
				</div>
			</div>		
			<div class="row">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='create' />
					<button type="submit" id="button-save" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o marginRightSm"></i>Save New Hoof Trim
					</button>
					<a href='index.php?amiID=<?php echo $amiID ?>' class="border-left pad-left margin-left">
						<i class="fa fa-paw margin-right-small"></i>Hoof Trim Main Page
					</a>
				</div>
			</div>
		</form>	
	</div> <!-- end main col -->
	
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
   	<?php include "../inc/sidebar.php" ?>
	</div> <!-- /sidebar -->
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?> 

<script type="text/javascript">
$(document).ready(function () {
   
   $(document).on("button-save", "click", function (){
      if ( $("#trimDate").val() == "" ) {
         alert("Please enter a trim date");
         return false;
      }
   });

   //fill in the next due date as one month ahead
	$('#trimDate').change(function(){
   	console.log($(this).val());
   	
		var $thisDate = $(this).val();
		var $dateArray = $thisDate.split('-');
		var $thisYear = $dateArray[0]; var $thisMonth = $dateArray[1]; var $thisDay = $dateArray[2];
		var $dueMonth = (parseInt($thisMonth)) + 1;
		
		// there's no month 14, flip it into next year
		if ($dueMonth > 12) {
			$dueMonth = $dueMonth - 12;
			var $dueYear = (parseInt($thisYear)) + 1;
			var $nextDue = $dueYear + "-" + $dueMonth + "-" + $thisDay;
		}
		else {	
			var $nextDue = $thisYear + "-" + $dueMonth + "-" + $thisDay;
		}		
		
		$('#trimDue').val($nextDue);
	});

});
</script>

</body>
</html>