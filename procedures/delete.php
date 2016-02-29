<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the goatID the form can use
$amiID = $_GET['amiID'];
$procID = $_GET['procID'];
 
try {

    // delete query
    $query = "DELETE FROM Procedures WHERE procID = ?";
    $stmt = $con->prepare($query);
    //get id from the URL
    $stmt->bindParam(1, $_GET['procID']);
     
    if($result = $stmt->execute()){
        // redirect to index page
        header('Location: /procedures/index.php?action=deleted&amiID='.$amiID);
    }else{
        die('Unable to delete record.');
    }
}
 
// to handle error
catch(PDOException $exception){
    echo "Error: " . $exception->getMessage();
}
?>