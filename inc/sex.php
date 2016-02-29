		
<?php
	
	$amiID = $_GET['amiID'];	
	
	//include database connection
	include '../libs/db_connect.php';
	
	$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
	 
	try {
	 
	    //get the info
	    $query = "SELECT name, sex FROM Individuals WHERE amiID = ?";
	    $stmt = $con->prepare( $query );
	    $stmt->bindParam(1, $_GET['amiID']);
	     
	    //execute our query
	    $stmt->execute();
	     
	    //store retrieved row to a variable
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	     
	    //values to fill up our form
	    $name = $row['name'];
	    $sex = $row['sex'];
	     
	} catch(PDOException $exception){ //to handle error
	    echo "Error: " . $exception->getMessage();
	}
?>	
<input type="hidden" id="inc-sex" value="<?php echo $sex ?>" />