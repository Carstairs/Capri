<!DOCTYPE HTML>
<html>
   <head>
      <title>Add a New Hoof Trim</title>
      <?php include("../assets/css/styles-include.html"); ?>
   </head>

<body>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>
				<span class="inlineBlock pull-left"><a href="/" class="border-none">Home</a> <i class="fa fa-angle-right"></i> Add A New Animal</span>
				<a class='btn btn-info btn-lg pull-right' href='/animals.php'><i class='fa fa-map-signs'></i>Animals List</a>
			</h1>
		</div>
	</div>
	
	
	<?php
		$action = isset($_POST['action']) ? $_POST['action'] : "";

		if($action=='create') {
		    //include database connection
		    include '../libs/db_connect.php';
		 
		    try {     
		        //write query
		        $query = "INSERT INTO Individuals 
	        				SET name = :name, dob = :dob,
	        				species = :species, breed  = :breed, color = :color, 
	        				fixed = :fixed, onFarm = :onFarm, lastUpdated = :lastUpdated, 
	        				notes = :notes, gender = :gender";
		 
		        //prepare query for excecution
		        $stmt = $con->prepare($query);
		 
		        //bind the parameters
		        //this is the first question mark
		        $stmt->bindParam(':name', $_POST['name']);
		 
		        //this is the second question mark, etc.
		        $stmt->bindParam(':dob', $_POST['dob']);
		        $stmt->bindParam(':gender', $_POST['gender']);
		        $stmt->bindParam(':species', $_POST['species']);
		        $stmt->bindParam(':breed', $_POST['breed']);
		        $stmt->bindParam(':color', $_POST['color']);
		        $stmt->bindParam(':fixed', $_POST['fixed']);
		        $stmt->bindParam(':onFarm', $_POST['onFarm']);
		        $stmt->bindParam(':lastUpdated', $_POST['lastUpdated']);
		        $stmt->bindParam(':notes', $_POST['notes']);
		        
		 
		        // Execute the query
		        if($stmt->execute()) {
		            echo '<div id="success-panel" class="panel panel-success nofade">
							<div class="panel-heading">
								<h3 class="panel-title">Added!</h3>
							</div>
							<div class="panel-body">
								The new animal\'s record was successfully saved. You can:
								<ul class="marginTop">
									<li><a href="/animals.php">Go to the All Animals page</a> and edit the new animal (or any other) from there</li>
									<li><a href="/index.php">Go to the App Home page</a></li>
							</div>
						</div>';
		        } else {
		            die('<div class="panel panel-danger">
		            	<div class="panel-heading">
		            		<h3 class="panel-title">Alas...</h3>
		            	</div>
		            	<div class="panel-body">
		            		The application was unable to save the new animal\'s record.
		            	</div>
		            </div>');
		        }
		         
		    } catch(PDOException $exception){ //to handle error
		        echo "Error: " . $exception->getMessage();
		    }
		}			 
	?>

	<form action='#' method='post' id='addAnimal' class="margin-top">
      <div class="row">
			<div class="col-sm-6">
				<label for="name">Name</label>
				<input type='text' name='name' class="form-control" />
			</div>
			<div class="col-sm-6">
				<label for="species">Species</label>
				<?php include '../inc/species.php' ?>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-6">
				<label for="dob">Date of Birth <small>yyyy-mm-dd</small></label>
				<input type='text' name='dob' class="datepicker js-date form-control" />
			</div>
			<div class="col-sm-6">
				<label for="gender">Gender</label>
				<label class="marginRight inlineBlock">
					<input type="radio" name="gender" value="0" checked="true"> 
					Female</label>
				<label class="inlineBlock">
					<input type="radio" name="gender" value="1">
					Male</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label for="breed">Breed</label>
				<input type='text' name='breed' class="form-control" />
			</div>
			<div class="col-sm-6">
				<label for="fixed">Fixed?</label>
				<label class="marginRight inlineBlock">
					<input type="radio" name="fixed" value="0" checked="true">
					No</label>
				<label class="inlineBlock">
					<input type="radio" name="fixed" value="1">
					Yes</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label for="color">Color</label>
				<input type="text" name="color" class="form-control" />
			</div>
			<div class="col-sm-6">
				<label for="onFarm">On Farm</label>
				<label class="marginRight inlineBlock">
					<input type="radio" name="onFarm" value="0">
					No</label>
				<label class="inlineBlock">
					<input type="radio" name="onFarm" value="1" checked="true">	
				 	Yes</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 ">
				<label for="notes">Notes</label>
				<textarea name="notes" rows="3" class="form-control"></textarea>
			</div>
		</div>			
		<div class="row">
			<div class="col-sm-12">
				<?php  
					$date = date('Y-m-d');
					echo "<input type='hidden' name='lastUpdated' value=$date />"; 
				?>
				<input type='hidden' name='action' value='create' />
				<button type="submit" class="btn btn-success tip" title="Click or press Enter to save">
					<i class="fa fa-floppy-o"></i>Save New Animal
				</button>
				<a href='/index.php' class="border-left pad-left margin-left">
					<i class="fa fa-home margin-right-small"></i>Home Page
				</a>
			</div>
		</div>
	</form>
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?>


</body>
</html>