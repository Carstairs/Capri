<!DOCTYPE HTML>
<html>
    <head>
        <title>Injuries & Illnesses</title>
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
		
		echo "<h1>Injuries &amp; Illnesses</h1>";		 
		echo "<div class='row'><div class='col-sm-12'><a class='btn btn-success' href='add.php?amiID=";
		echo $amiID;
		echo "'><i class='fa fa-plus'></i>Add New Injury or Illness</a></div></div>";	
		 
		// select all data
		$query = "SELECT * 
		FROM Injury 
		JOIN Individuals 
		ON Injury.amiID = Individuals.amiID 
		WHERE Injury.amiID=$amiID
		ORDER BY Injury.injBegan DESC";
		
		$stmt = $con->prepare( $query );
		$stmt->execute();

		// get number of rows returned
		$num = $stmt->rowCount();
		 
		if ($num > 0) { // if more than 0 record found
		 
		    echo "<div class='row'><div class='col-sm-12'><table class='table table-hover'>";
		     
		        //creating our table heading
		        echo "<thead><tr>";
		            echo "<th class='nobr'>Illness Date</th>";
					echo "<th class='nobr'>Illness End</th>";
		            echo "<th>Illness Description</th>";
		            echo "<th class='text-center'>Actions</th>";
		        echo "</tr></thead><tbody>";
		         
		        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            //this will make $row['firstname'] to just $firstname 
		            extract($row);
		            
		            // creating new table row per record
		            echo "<tr>";       
		                echo "<td class='nobr'>$injBegan</td>";
						echo "<td class='nobr'>$injEnd</td>";
		                echo "<td>$injDesc</td>";
		                echo "<td class='text-center nobr'>";
		                    echo "<a class='btn btn-primary btn-sm margin-right-small' href='edit.php?injID=$injID&amiID=$amiID'>
		                    	<i class='fa fa-pencil'	></i>Edit</a>";
		                    echo "<a id='$injID' class='btn btn-danger btn-sm margin-left-small deleteButton' href='#'>
		                    	<i class='fa fa-times'></i>Delete</a>";
		                echo "</td>";
		            echo "</tr>";
		        }     
		   	// end table
		   	echo "</tbody></table></div></div>";
		   	echo '<input type="hidden" id="amiID" name="amiID" value="'.$amiID.'" />';
			}
		 
		// if no records found
		else {
		    echo "<div class='row'><div class='col-sm-12'>No injuries on file</div></div>";
		}
	?>	
	</div>
	<div class="sidebar col-lg-3 col-lg-pull-9 col-sm-12 pageTop">
		<?php include '../inc/sidebar.php'; ?>
	</div> <!-- /sidebar -->
</div>

<!-- ************* Scripts ************* -->

<?php include("../assets/js/js-include.html"); ?> 

<script type='text/javascript'>
$(document).ready(function () {

	$('.deleteButton').click(function (){
		var $injID = $(this).attr('id');
		var $amiID = $('#amiID').val();
	
		var answer = confirm('Are you sure you want to delete this injury record?');
	    if ( answer ){     
	        // if user clicked ok, pass the id to delete.php and execute the delete query
	        window.location = '/injuries/delete.php?injID=' + $injID + '&amiID=' + $amiID;
	    }
	});

}); //end document ready
</script>

</body>
</html>
