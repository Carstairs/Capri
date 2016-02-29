<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the goatID the form can use
$amiID = $_GET['amiID'];
$weightID = $_GET['weightID']; 


try {
    // delete query
    $query = "DELETE FROM Weight WHERE weightID = $weightID";
    $stmt = $con->prepare($query);

    if($result = $stmt->execute()) {
        // redirect
        header('Location: /weight/index.php?action=deleted&amiID='.$amiID);
        
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