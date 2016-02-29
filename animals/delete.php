<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the goatID the form can use
$amiID = $_GET['amiID'];
 
try {

    // delete query
    $query = "DELETE FROM Individuals WHERE amiID = ?";
    $stmt = $con->prepare($query);
    //get id from the URL
    $stmt->bindParam(1, $_GET['amiID']);
     
    if($result = $stmt->execute()){
        // redirect to index page
        header('Location: /animals.php?action=deleted&amiID='.$amiID);
    }else{
        die('Unable to delete record.');
    }
}
 
// to handle error
catch(PDOException $exception){
    echo "Error: " . $exception->getMessage();
}
?>