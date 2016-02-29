<!DOCTYPE HTML>
<html>
    <head>
        <title>Breedings and Pregnancies</title>
        <?php include("../assets/css/styles-include.html"); ?>
    </head>
<body>
<div class="row">
	<div class="col-lg-8 col-lg-push-3 main">
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
						Breeding and/or pregnancy record was successfully deleted.
					</div>
				</div>';
		}
		 
		echo "<h1>Breedings and Pregnancies</h1>";
		echo "<div class='row'><div class='col-sm-12'><a class='btn btn-success' href='add.php?amiID=";
		echo $amiID;
		echo "'><i class='fa fa-plus'></i>Add New Pregnancy</a></div></div>";
		
		// select all data
		$query = "SELECT * 
		FROM Pregnancies 
		JOIN Individuals 
		ON Pregnancies.amiID = Individuals.amiID 
		WHERE Pregnancies.amiID=$amiID
		ORDER BY Pregnancies.pregDueDate DESC";
		
		$stmt = $con->prepare( $query );
		$stmt->execute();
		 
		// get number of rows returned
		$num = $stmt->rowCount();		
		 
		if ($num > 0) { // if more than 0 record found
		 
		    echo "<div class='row'><div class='col-sm-12'><table class='table table-hover'>";
		     
		        //creating our table heading
		        echo "<thead><tr>";
		        	echo "<th>Heat Date</th>";
		            echo "<th>Breeding Date</th>";
		            echo "<th>Due Due</th>";
		            echo "<th>Birth Date</th>";
		            echo "<th class='text-center'># Kids</th>";
		            echo "<th class='text-center' style='width: 300px;'>Actions</th>";
		        echo "</tr></thead><tbody>";
		         
		        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		            //this will make $row['firstname'] to just $firstname 
		            extract($row);
		            
		            //count up number of kids per birthing event
		            $girls = (int)$pregKidsFemale;
		            $boys = (int)$pregKidsMale;
		            $passed = (int)$pregKidsPassed;
		            $total = $girls + $boys + $passed;
		            $tooltipTotal = 'Offspring breakdown: '.$girls.' Female, '.$boys.' Male, '.$passed.' Passed Away';
		            
		            // creating new table row per record
		            echo "<tr>";    
		            	echo "<td>$heatBeganDate</td>";   
		                echo "<td>$pregBreedDate</td>";
		                echo "<td>$pregDueDate</td>";
		                echo "<td class='js-date-birth'>$pregBirthDate</td>";		// .js-date-birth and .js-kids are linked
		                echo '<td class="text-center"><span class="tipster kids" title="'.$tooltipTotal.'">';
		                echo $total;
		                echo "</span></td>";
		                echo "<td class='text-center'>";
		                    echo "<a class='btn btn-primary btn-sm margin-right-small' href='edit.php?pregID=$pregID&amiID=$amiID'>
		                    	<i class='fa fa-pencil'	></i>Edit</a>";
		                    echo "<a id='$pregID' class='btn btn-danger btn-sm deleteButton' href='#'>
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
		    echo "<div class='row'><div class='col-sm-12'>No pregnancies on file</div></div>";
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
			var $pregID = $(this).attr('id');
			var $amiID = $('#amiID').val();
		
			var answer = confirm('Are you sure you want to delete this pregnancy record?');
		    if ( answer ){     
		        // if user clicked ok, pass the id to delete.php and execute the delete query
		        window.location = '/pregnancies/delete.php?pregID=' + $pregID + '&amiID=' + $amiID;
		    }
		});
		
		// if there's no birthdate then remove 0 # kids text
		$(".js-date-birth").each(function () {
			var theDate = $(this).text();
			var numKids = $(this).next().find(".kids").text();

			if (theDate === "" && numKids === "0") {
				$(this).next().find(".kids").text("");
			}
		});
		
	}); //end document ready
</script>

</body>
</html>
