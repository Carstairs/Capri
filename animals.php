<!DOCTYPE HTML>
<html>
<head>
	<title>All Animals: Farm Records</title>
	<?php include("assets/css/styles-include.html"); ?>
</head>
<body>
   
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>
				<span class="inlineBlock pull-left"><a href="/" class="border-none">Home</a> <i class="fa fa-angle-right"></i> All Animals</span>
				<a class="btn btn-info btn-lg pull-right" href='/animals/add.php'><i class='fa fa-plus'></i>Add A New Animal</a>
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<?php
			//include database connection
			include 'libs/db_connect.php';
			 
			$action = isset($_GET['action']) ? $_GET['action'] : "";
			 
			// if it was redirected from delete.php
			if($action=='deleted') {
					echo '<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Delete Confirmed</h3>
					</div>
					<div class="panel-body">
						Record was successfully deleted.
					</div>
					</div>';
			}
		?>
		
		<?php
			//include database connection
			include 'libs/db_connect.php';

			//select all data
			$query = "SELECT * FROM Individuals WHERE onFarm = 1 ORDER BY onFarm DESC, name ASC";

			$stmt = $con->prepare( $query );
			$stmt->execute();

			// get number of rows returned
			$num = $stmt->rowCount();

			if ( $num > 0 ) { // if records found
				echo "<h2>On The Farm</h2>";
				echo "<table class='table table-striped table-hover'>";
				echo "<thead><tr>";
					echo "<th>Name</th>";
					echo "<th>Gender</th>";
					echo "<th>Species</th>";
					echo "<th class='hide-small'>Breed</th>";
					echo "<th class='hide-small'>Color</th>";
					echo "<th class='text-center'>Actions</th>";
				echo "</tr></thead><tbody>";

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					//extract row
					//this will make $row['firstname'] to just $firstname 
					extract($row);

					// set up the English text versions of the Booleans
					$activeGenderText = 'Not Set'; $activeInjuryText = ''; 
					$onFarmText = ''; $fixedText = '';
					
					if ($gender == "0")
						{ $activeGenderText = "Female"; }
					elseif ($gender == "1") 
						{ $activeGenderText = "Male"; }
					
					if ($activeInjury == "0")
						{ $activeInjuryText = "No"; }
					else 
						{ $activeInjuryText = "Yes"; }
					
					if ($fixed == "0")
						{ $fixedText = "Not neutered/spayed"; }
					else 
						{ $fixedText = "Has been neutered/spayed"; }
					
					// creating new table row per record
					echo "<tr>";
						echo "<td><a class='tipster' title='Edit details' href='/animals/edit.php?amiID={$amiID}'>{$name}</a></td>";
						echo "<td><span class='tipster' title='";
						echo $fixedText;
						echo "'>";
						echo $activeGenderText;
						echo "</span></td>";
						echo "<td>{$species}</td>";
						echo "<td class='hide-small'>{$breed}</td>";
						echo "<td class='hide-small'>{$color}</td>";							  
						echo "<td class='text-center nobr' style='width: 150px'><div class='btn-group' role='group' aria-label='Animal Actions'>";
						echo "<a class='btn btn-primary' href='/animals/edit.php?amiID={$amiID}'><i class='fa fa-pencil margin-right-none'></i></a>";
						echo "<a class='btn btn-default' href='/animals/index.php?amiID={$amiID}'><i class='fa fa-eye margin-right-none'></i></a>";								  
						echo "<a class='btn btn-danger' href='#' onclick='delete_user({$amiID});'><i class='fa fa-times margin-right-none'></i></a>";
						echo "</div></td>";
					echo "</tr>";
				}
				// end table
				echo "</tbody></table>";
				}
			// if no records found
			else {
				echo "No records found.";
			}
		?>	

		<?php
			//include database connection
			include 'libs/db_connect.php';

			// select all data
			$query = "SELECT * FROM Individuals WHERE onFarm = 0 ORDER BY onFarm DESC, name ASC";

			$stmt = $con->prepare( $query );
			$stmt->execute();

			// get number of rows returned
			$num = $stmt->rowCount();

			if ( $num > 0 ) { // if more than 0 record found
				echo "<h2>Not On The Farm</h2>";
				echo "<table class='table table-striped table-hover fullWidth'>";

				//creating our table heading
				echo "<thead><tr>";
					echo "<th>Name</th>";
					echo "<th>Gender</th>";
					echo "<th>Species</th>";
					echo "<th class='hide-small'>Breed</th>";						   
					echo "<th class='hide-small'>Color</th>";					  							  						 
					echo "<th class='text-center' style='width: 150px;'>Actions</th>";
				echo "</tr></thead><tbody>";

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					//extract row
					//this will make $row['firstname'] to just $firstname 
					extract($row);

					// set up the English text versions of the Booleans
					$activeGenderText = 'Not Set'; $activeInjuryText = ''; 
					$onFarmText = ''; $fixedText = '';

					if ($gender == "0") 
						{ $activeGenderText = "Female"; }
					elseif ($gender == "1") 
						{ $activeGenderText = "Male"; }

					if ($activeInjury == "0")
						{ $activeInjuryText = "No"; }
					else 
						{ $activeInjuryText = "Yes"; }
					
					if ($fixed == "0")
					{ $fixedText = "Not neutered/spayed"; }
					else { $fixedText = "Has been neutered/spayed"; }
					
					// creating new table row per record
					echo "<tr>";
						echo "<td><a class='tipster' title='Edit animal details' href='/animals/edit.php?amiID={$amiID}'>{$name}</a></td>";
						echo "<td><span class='tipster' title='";
						echo $fixedText;
						echo "'>";
						echo $activeGenderText;
						echo "</span></td>";
						echo "<td>{$species}</td>";
						echo "<td class='hide-small'>{$breed}</td>";
						echo "<td class='hide-small'>{$color}</td>";						 
						echo "<td class='text-center nobr' style='width: 150px'><div class='btn-group' role='group' aria-label='Animal Actions'>";
						echo "<a class='btn btn-primary small' href='/animals/edit.php?amiID={$amiID}'><i class='fa fa-pencil margin-right-none'></i></a>";
						echo "<a class='btn btn-default small' href='/animals/index.php?amiID={$amiID}'><i class='fa fa-eye margin-right-none'></i></a>";								   
						echo "<a class='btn btn-danger small' href='#' onclick='delete_user({$amiID});'><i class='fa fa-times margin-right-none'></i></a>";
						echo "</div></td>";
					echo "</tr>";
				}	 
				// end table
				echo "</tbody></table>";
			}
			// if no records found
			else {}
		?>
		</div>
	</div>
</div>

<?php include("assets/js/js-include.html"); ?> 

<script type='text/javascript'>
function delete_user( amiID ){	   
	var answer = confirm('Are you sure you want to delete this animal?');
	if ( answer ){	   
		// if user clicked ok, pass the id to delete.php and execute the delete query
		window.location = 'animals/delete.php?amiID=' + amiID;
	} 
}

$(document).ready(function () {
	if ($('.panel').length > 0) {
		setTimeout(function () {
			 $('.panel').slideUp('slow')
		}, 4000);
	}
}); //end document ready

</script>

</body>
</html>
