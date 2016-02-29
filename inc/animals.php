<?php
	//include database connection
	include '../libs/db_connect.php';
	
	// select all data
	$query = "SELECT * FROM Individuals ORDER BY onFarm DESC, name ASC";
	
	$stmt = $con->prepare( $query );
	$stmt->execute();
	 
	// get number of rows returned
	$num = $stmt->rowCount();
	 
	if ( $num > 0 ) {
	    echo "<select name='amiID-2'>";
	        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	            extract($row);
	            echo "<option value='{$amiID}'>{$name}</option>";                  
	        }     
	   	// end table
	   	echo "</select>";
		}
	else {
	    echo "No records found.";
	}
?>
