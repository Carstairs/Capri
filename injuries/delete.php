<?php
//include database connection
include '../libs/db_connect.php';

// set up a variable with the goatID the form can use
$amiID = $_GET['amiID'];
$injID = $_GET['injID'];
 
try {

    // delete query
    $query = "DELETE FROM Injury WHERE injID = ?";
    $stmt = $con->prepare($query);
    //get id from the URL
    $stmt->bindParam(1, $_GET['injID']);
     
    if($result = $stmt->execute()){
        // redirect to index page
        header('Location: /injuries/index.php?amiID='.$amiID.'&action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
 
// to handle error
catch(PDOException $exception){
    echo "Error: " . $exception->getMessage();
}
?>