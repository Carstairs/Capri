<?php

	//include database connection
	include '../libs/db_connect.php';

	 echo '<select id="species" name="species" class="form-control">';
	 	echo '<option>Select Species</option>';

	    $query = "SELECT name FROM Species";
	    $stmt = $con->prepare( $query );
	    $stmt->execute();


		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
		}

	 echo '</select>';

?>