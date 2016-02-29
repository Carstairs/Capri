<!DOCTYPE HTML>
<html>

<head>
    <title>Add a New Vaccine</title>
    <?php include("styles/styles-include.html"); ?>
</head>

<body>
<div class="row">
	<div class="small-12 columns">		
		<?php include("vax/ajaxAdd.php") ?>
		
		<h1 class="marginBottomNo">Add a New Vaccine</h1>

		<form action='#' method='post' id='bulkVax' class="marginTopBig">
			<div class="row">
				<div class="medium-3 columns">
					<label for="vaxDate">Vaccine Date <small>yyyy-mm-dd</small></label>
					<input type='text' name='vaxDate' class='datepicker' value=""  />
				</div>
				<div class="medium-6 end columns">
					<?php
						//include database connection
						include 'libs/db_connect.php';
						$query = "SELECT * FROM Individuals ORDER BY onFarm DESC, name ASC";			
						$stmt = $con->prepare( $query );
						$stmt->execute();
					
						$num = $stmt->rowCount();			 
						if ( $num > 0 ) {
							echo "<label for='amiID'>Vaccinated Animal</label>";
						    echo "<select name='amiID'><option>Select Animal</option>";
						        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						            extract($row);
						            echo "<option value='{$amiID}'>{$name}</option>";                  
						        }     
						   	// end table
						   	echo "</select>";
							}
						else {
						    echo "No animals found.";
						}
					?>
				</div>
			</div>
			<div class="row">
				<div class="medium-3 columns">
					<label for="vaxDue">Vaccine Due <small>yyyy-mm-dd</small></label>
					<input type='text' name='vaxDue' class='datepicker' value="" />
				</div>
				<div class="medium-6 end columns">
					<label>Vaccine Description</label>
					<input type="text" name="vaxDesc" value="" />
				</div>								
			</div>
			
			<div class="row">
				<div class="small-8 end columns">
				
				</div>
			</div>
			
			<div class="row">
				<div class="small-12 columns">
					<input type='hidden' name='action' value='create' />
					<button type="submit" class="success">
						<i class="fa fa-floppy-o marginRightSm"></i>Save New Vaccine
					</button>
				</div>
			</div>
			
		</form>
	</div> <!-- end container -->

</div>

<!-- ************* Scripts ************* -->

<?php include("js/js-include.html"); ?>

<script type="text/javascript">	 
$(document).ready(function () {
	 
	$('#bulkVax').foundation({bindings:'events'});

});
</script>

</body>
</html>


			
