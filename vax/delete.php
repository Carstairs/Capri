<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the amiID the form can use
$amiID = $_GET['amiID'];
$vaxID = $_GET['vaxID']; 


try {
    // delete query
    $query = "DELETE FROM Vaccines WHERE vaxID = $vaxID";
    $stmt = $con->prepare($query);

    if($result = $stmt->execute()) {
        // redirect
        header('Location: /vax/index.php?action=deleted&amiID='.$amiID);
        
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