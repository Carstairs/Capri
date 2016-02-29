<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the goatID the form can use
$amiID = $_GET['amiID'];
$trimID = $_GET['trimID']; 


try {
    // delete query
    $query = "DELETE FROM HoofTrims WHERE trimID = $trimID";
    $stmt = $con->prepare($query);

    if($result = $stmt->execute()) {
        // redirect
        header('Location: /hoof-trims/index.php?action=deleted&amiID='.$amiID);
        
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