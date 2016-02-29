<!DOCTYPE HTML>
<html>
<head>
	<title>Home: Farm Records</title>
	<?php include("assets/css/styles-include.html"); ?>
</head>

<body>	
<div class="container home">
	<div class="row">
		<h1>
			<span class="pull-left inlineBlock">Farm Records</span> 
			<a class="pull-right btn btn-info btn-lg inlineBlock" href="/animals.php"><i class="fa fa-map-signs"></i>List Of The All Animals</a>
		</h1>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info margin-bottom">
				<div class="panel-heading">
					<h3 class="panel-title">Active Injuries</h3>
				</div>
				<div class="panel-body">
					<?php
						//include database connection
						include 'libs/db_connect.php';

						$action = isset($_GET['action']) ? $_GET['action'] : "";

						// select all data
						$query = "SELECT * 
						FROM Injury 
						JOIN Individuals 
						ON Injury.amiID = Individuals.amiID 
						WHERE Injury.injBegan BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
						AND Injury.injEnd	 = 0000-00-00";

						$stmt = $con->prepare( $query );
						$stmt->execute();

						// get number of rows returned
						$num = $stmt->rowCount();

						if ( $num > 0 ) { // if more than 0 record found
							echo "<ul>";

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
								extract($row);
								echo "<li><a href='/injuries/edit.php?injID={$injID}&amiID={$amiID}' class='tipster' title=\"Edit $name's Injury/Illness Record\">{$name}</a>: {$injBegan} {$injDesc}</li>";
							}
							// end list
							echo "</ul>";
						}
						else {
							echo "<p>No animals have active/unresolved injuries in the last 30 days.</p>";
						}
					?>
				</div>
			</div>
		</div>
	</div>
	

	<div class="row marginTop">
		<div class="col-sm-12 col-md-6 marginBottom">
			<h2>In the Next Week</h2>

			<?php
				//include database connection
				include 'libs/db_connect.php';

				$action = isset($_GET['action']) ? $_GET['action'] : "";

				// select all data
				$query = "SELECT * 
				FROM Pregnancies 
				JOIN Individuals 
				ON Pregnancies.amiID = Individuals.amiID 
				WHERE Pregnancies.pregDueDate > CURDATE() AND Pregnancies.pregDueDate < CURDATE() + 7
				ORDER BY Pregnancies.pregDueDate ASC";

				$stmt = $con->prepare( $query );
				$stmt->execute();

				// get number of rows returned
				$num = $stmt->rowCount();

				if ( $num > 0 ) { // if more than 0 record found
					echo "<h3>Babies Due</h3>";
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							echo "<li><a href='/pregnancies/edit.php?pregID=$pregID&amiID=$amiID' class='tipster' title=\"Edit $name's Pregnancy Record\">{$pregDueDate} - {$name}</a></li>";
						}	  
				   	echo "</ul>";
				}
				
			?>

			
			<h3>Vaccines</h3>
			<?php
				//include database connection
				include 'libs/db_connect.php';
				 
				$action = isset($_GET['action']) ? $_GET['action'] : "";
				
				// select all data
				$query = "SELECT * 
				FROM Vaccines 
				JOIN Individuals 
				ON Vaccines.amiID = Individuals.amiID 
				WHERE Vaccines.vaxDue > CURDATE() AND vaxDue < CURDATE() + 7
				ORDER BY Vaccines.vaxDue ASC";
				
				$stmt = $con->prepare( $query );
				$stmt->execute();
				 
				// get number of rows returned
				$num = $stmt->rowCount();
				 
				if ( $num > 0 ) { // if more than 0 record found
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							echo "<li><a href='/vax/edit.php?vaxID=$vaxID&amiID=$amiID' title=\"Edit $name's Vaccine Record\">{$vaxDue} - {$vaxDesc} for {$name}</a></li>";
						}	  
				   	echo "</ul>";
				}
				else {
					echo "No vaccines due.";
				}
			?>	

			
			<h3>Hoof Trims</h3>
			<?php
				//include database connection
				include 'libs/db_connect.php';
				 
				$action = isset($_GET['action']) ? $_GET['action'] : "";
				
				// select all data
				$query = "SELECT * 
				FROM HoofTrims 
				JOIN Individuals 
				ON Vaccines.amiID = Individuals.amiID 
				WHERE HoofTrims.trimDue > CURDATE() AND HoofTrims.trimDue < CURDATE() + 7
				ORDER BY HoofTrims.trimDue ASC";
				
				$stmt = $con->prepare( $query );
				$stmt->execute();
				 
				// get number of rows returned
				$num = $stmt->rowCount();
				 
				if ( $num > 0 ) { // if more than 0 record found
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							echo "<li><a href='/vax/edit.php?vaxID=$vaxID&amiID=$amiID' class='tipster' title=\"Edit $name's Vaccine Record\">{$vaxDue} - {$vaxDesc} for {$name}</a></li>";
						}	  
				   	echo "</ul>";
				}
				else {
					echo "No hoof trims due.";
				}
			?>		
		
			<h3 class="marginTop">Supplements</h3>
			<?php
				//include database connection
				include 'libs/db_connect.php';
				 
				$action = isset($_GET['action']) ? $_GET['action'] : "";
				
				// select all data
				$query = "SELECT * 
				FROM Supplements 
				JOIN Individuals 
				ON Supplements.amiID = Individuals.amiID 
				WHERE Supplements.suppDue > CURDATE() AND Supplements.suppDue < CURDATE() + 7
				ORDER BY Supplements.suppDue ASC";
				
				$stmt = $con->prepare( $query );
				$stmt->execute();
				 
				// get number of rows returned
				$num = $stmt->rowCount();
				 
				if ( $num > 0 ) { // if more than 0 record found
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							echo "<li><a href='/supplements/edit.php?suppID=$suppID&amiID=$amiID' class='tipster' title=\"Edit $name's Supplements Record\">{$suppDue} - ${$suppDesc} for {$name}</a></li>";
						}	  
				   	// end table
				   	echo "</ul>";
				}
				 
				// if no records found
				else {
					echo "No supplements due.";
				}
			?>	
		</div>

		<div class="col-sm-12 col-md-6">
			<h2>After Next Week</h2>
			
			<?php
				//include database connection
				include 'libs/db_connect.php';
				 
				$action = isset($_GET['action']) ? $_GET['action'] : "";
				
				// select all data
				$query = "SELECT * 
				FROM Pregnancies 
				JOIN Individuals 
				ON Pregnancies.amiID = Individuals.amiID 
				WHERE Pregnancies.pregDueDate > CURDATE() + 7 AND Pregnancies.pregDueDate < CURDATE() + 37
				ORDER BY Pregnancies.pregDueDate ASC";

				$stmt = $con->prepare( $query );
				$stmt->execute();
				 
				// get number of rows returned
				$num = $stmt->rowCount();
				 
				if ( $num > 0 ) { // if more than 0 record found
					echo "<h3>Babies Due</h3>";
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							echo "<li><a href='/pregnancies/edit.php?pregID=$pregID&amiID=$amiID' class='tipster' title=\"Edit $name's Pregnancy Record\">{$pregDueDate} - {$name}</a></li>";
						}	  
				   	echo "</ul>";
				}
				
			?>
			
			<h3>Vaccines</h3>
			<?php
				//include database connection
				include 'libs/db_connect.php';
				 
				$action = isset($_GET['action']) ? $_GET['action'] : "";
				
				// select all data
				$query = "SELECT * 
				FROM Vaccines 
				JOIN Individuals 
				ON Vaccines.amiID = Individuals.amiID 
				WHERE Vaccines.vaxDue > CURDATE() + 7 AND vaxDue < CURDATE() + 37
				ORDER BY Vaccines.vaxDue ASC";
				
				$stmt = $con->prepare( $query );
				$stmt->execute();
				 
				// get number of rows returned
				$num = $stmt->rowCount();
				 
				if ( $num > 0 ) { // if more than 0 record found
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);				  
							echo "<li><a href='/vax/edit.php?vaxID=$vaxID&amiID=$amiID' class='tipster' title=\"Edit $name's Vaccine Record\">{$vaxDue} - {$vaxDesc} for {$name}</a></li>";
						}
							// end table
				   	echo "</ul>";
				}
				 
				// if no records found
				else {
					echo "No vaccines due.";
				}
			?>	

			<h3 class="marginTop">Supplements</h3>
			<?php
				//include database connection
				include 'libs/db_connect.php';
				 
				$action = isset($_GET['action']) ? $_GET['action'] : "";
				
				// select all data
				$query = "SELECT * 
				FROM Supplements 
				JOIN Individuals 
				ON Supplements.amiID = Individuals.amiID 
				WHERE Supplements.suppDue > CURDATE() + 7 AND Supplements.suppDue < CURDATE() + 37
				ORDER BY Supplements.suppDue ASC";
				
				$stmt = $con->prepare( $query );
				$stmt->execute();
				 
				// get number of rows returned
				$num = $stmt->rowCount();
				 
				if ( $num > 0 ) { // if more than 0 record found
					echo "<ul>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							echo "<li><a href='/supplements/edit.php?suppID=$suppID&amiID=$amiID' class='tipster' title=\"Edit $name's Supplements Record\">{$suppDue} - {$suppDesc} for {$name}</a></li>";
						}	  
				   	// end table
				   	echo "</ul>";
				} 
				// if no records found
				else {
					echo "No supplements due.";
				}
			?>	
		</div>
	</div>
	
	<div class="row marginTop">
		<div class="col-sm-12">
			<img src="images/Shadden-and-Ginger-as-kids.jpg" style="max-width: 980px; width: 100%;" alt="Shadden and Ginger when they were kids">
		</div>
	</div>
</div>

<?php include("../assets/js/js-include.html"); ?> 

</body>
</html>
