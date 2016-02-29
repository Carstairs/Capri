<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the amiID the form can use
$amiID = $_GET['amiID'];
$suppID = $_GET['suppID']; 

try {
	// delete query
	$query = "DELETE FROM Supplements WHERE suppID = ?";
	$stmt = $con->prepare($query);
	//get id from the URL
	$stmt->bindParam(1, $_GET['suppID']);

	if($result = $stmt->execute()){
		// redirect to section index page
		header('Location: /supplements/index.php?action=deleted&amiID='.$amiID);
	}
	else {
		die('Unable to delete record.');
	}
}
 
// to handle error
catch(PDOException $exception) {
	echo "Error: " . $exception->getMessage();
}
?>