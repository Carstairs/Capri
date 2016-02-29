<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the amiID the form can use
$amiID = $_GET['amiID'];
$pregID = $_GET['pregID'];
 
try {
	// delete query
	$query = "DELETE FROM Pregnancies WHERE pregID = ?";
	$stmt = $con->prepare($query);
	//get id from the URL
	$stmt->bindParam(1, $_GET['pregID']);

	if($result = $stmt->execute()){
		// redirect to section index page
		header('Location: /pregnancies/index.php?action=deleted&amiID='.$amiID);
	} 
	else {
		die('Unable to delete record.');
	}
}
 
// to handle error
catch(PDOException $exception){
	echo "Error: " . $exception->getMessage();
}
?>