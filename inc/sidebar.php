
<?php
	$amiID = $_GET['amiID'];	
	
	//include database connection
	include '../libs/db_connect.php';
	 
   try {
	   //get the info
      $query = "SELECT name, gender FROM Individuals WHERE amiID = $amiID";

      // select all data
		$stmt = $con->prepare($query);

      $stmt->execute();
      
      //store retrieved row to a variable
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      //values from the query
      $name = $row['name'];
      $gender = $row['gender'];    
            
	} 
	catch(PDOException $exception){ //to handle error
	    echo "Error: " . $exception->getMessage();
	}
?>	

<h3 class="text-center margin-bottom margin-top"><?php echo $name ?></h3>

<input type="hidden" id="name" value="<?php echo $name ?>" />
<input type="hidden" id="gender" value="<?php echo $gender ?>" />

<ul class="side-nav">
   <li>
      <a href="/animals/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Home Page">
         <i class="fa fa-info-circle marginRightSm"></i>Basic Information
      </a>
   </li>
   <li>
      <a href="/hoof-trims/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Hoof Trims">
         <i class="fa fa-paw marginRightSm"></i>Hoof Trims
      </a>
   </li>
   <li>
      <a href="/weight/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Weights">
         <i class="fa fa-tachometer marginRightSm"></i>Weights
      </a>
   </li>
   <li>
      <a href="/supplements/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Supplements">
         <i class="fa fa-eyedropper marginRightSm"></i>Supplements</a>
      </a>
   </li>
   <li>
      <a href="/vax/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Vaccines">
         <i class="fa fa-medkit marginRightSm"></i>Vaccines
      </a>
   </li>
   <li>
      <a href="/injuries/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Injuries & Illnesses">
         <i class="fa fa-wheelchair marginRightSm"></i>Injuries &amp; Illnesses  
      </a>
   </li>
   
   <?php 
      if ($gender == "0") {
         echo '<li> <a href="/pregnancies/index.php?amiID='.$amiID;
         echo '" class="tip" title="<?php echo $name ?>\'s Pregnancies"><i class="fa fa-female marginRightSm"></i>Pregnancies</a></li>';
      }
   ?>    
  
   
   <li>
      <a href="/procedures/index.php?amiID=<?php echo $amiID ?>" class="tip" title="<?php echo $name ?>'s Procedures & Surgeries">
         <i class="fa fa-ambulance marginRightSm"></i>Procedures
      </a>
   </li>
</ul>

<ul class="side-nav margin-top-big">
   <li>
      <a href="/animals.php" title="All of the animals"><i class="fa fa-map-signs"></i>Animals List</a>
   </li>
   <li>
      <a href="/" title="Records App Home Page"><i class="fa fa-home"></i>Records Home Page</a>
   </li>
</ul>

