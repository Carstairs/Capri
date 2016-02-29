<!DOCTYPE HTML>
<html>

<head>
    <title>Add a New Pregnancy</title>
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
			        $query = "INSERT INTO Pregnancies 
		        			  SET amiID = :amiID, 
		        				pregSire = :pregSire, 
		        				heatBeganDate = :heatBeganDate,
		        				pregBreedDate = :pregBreedDate, 
		        				pregResulted = :pregResulted, 
		        				pregDueDate = :pregDueDate, 
		        				pregBirthDate = :pregBirthDate,
		        				pregKidsFemale = :pregKidsFemale,
		        				pregKidsMale = :pregKidsMale,
								pregKidsPassed = :pregKidsPassed";
			 		
			        //prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        //bind the parameters
			        $stmt->bindParam(':amiID', $_POST['amiID']);
			        $stmt->bindParam(':pregSire', $_POST['pregSire']);
			        $stmt->bindParam(':heatBeganDate', $_POST['heatBeganDate']);
			        $stmt->bindParam(':pregBreedDate', $_POST['pregBreedDate']);
			        $stmt->bindParam(':pregResulted', $_POST['pregResulted']);
			        $stmt->bindParam(':pregDueDate', $_POST['pregDueDate']);
			        $stmt->bindParam(':pregBirthDate', $_POST['pregBirthDate']);
			        $stmt->bindParam(':pregKidsFemale', $_POST['pregKidsFemale']);
			        $stmt->bindParam(':pregKidsMale', $_POST['pregKidsMale']);
			        $stmt->bindParam(':pregKidsPassed', $_POST['pregKidsPassed']);
			 
			        // Execute the query
			        if($stmt->execute()) {
			            echo '<div id="success-panel" class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Added!</h3>
								</div>
								<div class="panel-body">
									The new pregnancy was successfully saved. 
								</div>
							</div>';
			        } 
			        else {
			            die('<div class="panel panel-danger">
			            	<div class="panel-heading">
			            		<h3 class="panel-title">Alas...</h3>
			            	</div>
			            	<div class="panel-body">
			            		The application was unable to save the new pregnancy record.
			            	</div>
			            </div>');
			        }
			         
			    } catch(PDOException $exception) { //to handle error
			        echo "Error: " . $exception->getMessage();
			    }
			}			 
		?>
		
		
		<h1>Add a New Pregnancy</h1>

		
		<!--we have our html form here where information will be entered-->
		<form action='#' method='post' id='addPreg'>
		<input type="hidden" name="amiID" value="<?php echo $amiID ?>" />
		
			<div class="row">
				<div class="col-md-4">
					<label for="heatBeganDate">Heat Began Date</label>
					<input type='text' name='heatBeganDate' class="form-control js-date datepicker" />
				</div>
				<div class="col-md-4">
					<label for="dob">Sire</label>
					<input type='text' name='pregSire' class="form-control" value="" />
				</div>
				<div class="col-md-4">
					<label for="pregResulted">Pregnancy Resulted</label>
					<label class="inlineBlock marginRight">
						<input type="radio" name="pregResulted" value="0" checked /> No
					</label>
					<label class="inlineBlock">
						<input type="radio" name="pregResulted" value="1" /> Yes
					</label>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-4 end">
					<label for="name">Breed Date <small>yyyy-mm-dd</small></label>
					<input type='text' name='pregBreedDate' class='form-control js-date datepicker' />			
				</div>
				<div class="col-md-4">
					<label for="pregDueDate">Due Date <small>yyyy-mm-dd</small></label>
					<input type="text" name="pregDueDate" class="form-control js-date datepicker" value="" />
				</div>
				<div class="col-md-4">
					<label for="pregBirthDate">Birth Date <small>yyyy-mm-dd</small></label>
					<input type="text" name="pregBirthDate" class="form-control js-date datepicker" value="" />
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
					<select name="pregKidsFemale" class="form-control">
						<option>Select Number</option>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="pregKidsMale">Male Offspring</label>
					<select name="pregKidsMale" class="form-control">
						<option>Select Number</option>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
				<div class="col-md-4">
					<label for="pregKidsPassed">Offspring Passed Away</label>
					<select name="pregKidsPassed" class="form-control">
						<option>Select Number</option>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</div>
			</div>

			<div class="row margin-top-xl">
				<div class="col-sm-12">
					<input type='hidden' name='action' value='create' />
					<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
						<i class="fa fa-floppy-o"></i>Save New Pregnancy
					</button>
					<a href='index.php?amiID=<?php echo $amiID ?>' class="border-left pad-left margin-left">
						<i class="fa fa-female margin-right-small"></i>Pregnancies Main Page
					</a>
				</div>
			</div>
		</form>
	</div> <!-- end body -->
	
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div> <!-- /sidebar -->
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?>



</body>
</html>