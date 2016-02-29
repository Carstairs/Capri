<!DOCTYPE HTML>
<html>
    <head>
        <title>Hoof Trims</title>
        <?php include("../assets/css/styles-include.html"); ?>
    </head>
<body>
   
   
<div class="row">
	<div class="main col-lg-8 end col-lg-push-3">			
	<?php		
		// set up a variable with the goatID the form can use
		$amiID = $_GET['amiID'];
		
		//include database connection
		include '../libs/db_connect.php';
		 
		$action = isset($_GET['action']) ? $_GET['action'] : "";
		 
		// if it was redirected from delete.php
		if ($action == 'deleted') {
		    echo '<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Delete Confirmed</h3>
					</div>
					<div class="panel-body">
						Hoof trim was successfully deleted.
					</div>
				</div>';
		}
		
		echo "<h1>Hoof Trims</h1>";
		echo "<div class='row'><div class='col-sm-12'><a class='btn btn-success' href='add.php?amiID=";
		echo $amiID;
		echo "'><i class='fa fa-plus'></i>Add New Hoof Trim</a></div></div>";
		 
		// select all data
		$query = "SELECT * 
		FROM HoofTrims 
		JOIN Individuals 
		ON HoofTrims.amiID = Individuals.amiID 
		WHERE HoofTrims.amiID=$amiID
		ORDER BY HoofTrims.trimDue DESC";
		
		//$query = "SELECT * FROM HoofTrims WHERE amiID = $URLamiID";
		$stmt = $con->prepare( $query );
		$stmt->execute();

		// get number of rows returned
		$num = $stmt->rowCount();
		 
		if ($num > 0) { // if more than 0 record found
		 
		    echo "<div class='row'><div class='col-sm-12'><table class='table table-hover'>";
		     
		        //creating our table heading
		        echo "<thead><tr>";
		            echo "<th>Trim Date</th>";
		            echo "<th>Trim Due</th>";
		            echo "<th class='text-center'>Actions</th>";
		        echo "</tr></thead><tbody>";
		         
		        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            //this will make $row['firstname'] to just $firstname 
		            extract($row);
		            
		            // creating new table row per record
		            echo "<tr>";       
		                echo "<td>$trimDate</td>";
		                echo "<td>$trimDue</td>";
		                echo "<td class='text-center'>";
		                    echo "<a class='btn btn-primary btn-sm margin-right margin-right-small' href='/hoof-trims/edit.php?trimID=$trimID&amiID=$amiID'>
		                    	<i class='fa fa-pencil'	></i>Edit</a>";
		                    echo "<a id='$trimID' class='btn btn-danger btn-sm margin-left-small deleteButton' href='#'>
		                    	<i class='fa fa-times'></i>Delete</a>";
		                echo "</td>";
		            echo "</tr>";
		        }     
		   	// end table
		   	echo "</tbody></table></div></div>";
		   	echo '<input type="hidden" id="amiName" name="amiName" value="'.$name.'" />';
		   	echo '<input type="hidden" id="amiID" name="amiID" value="'.$amiID.'" />';
			}
		 
		// if no records found
		else {
		    echo "<div class='row'><div class='col-sm-12'><p class='marginBottom'>No hoof trims on file</p></div></div>";
		}
	?>	
	</div>
	<div class="sidebar col-lg-3 col-lg-pull-9 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div> <!-- /sidebar -->
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?>

<script type='text/javascript'>
$(document).ready(function () {

	$('.deleteButton').click(function (){
		var $trimID = $(this).attr('id');
		var $amiID = $('#amiID').val();
	
		var answer = confirm('Are you sure you want to delete this hoof trim record?');
	    if ( answer ){     
	        // if user clicked ok, pass the id to delete.php and execute the delete query
	        window.location = '/hoof-trims/delete.php?trimID=' + $trimID + '&amiID=' + $amiID;
	    }
	});

}); //end document ready
</script>

</body>
</html>
