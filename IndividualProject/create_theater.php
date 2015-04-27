<!-- Admin: Create Theater -->

<?php
	//check that admin is logged in
	session_start();
	$sess_id = 'loggedin';
	if($_SESSION['admin']!=$sess_id)
		header("Location: index.php");
	
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $addressError = null;
		$cityError = null;
		$stateError = null;
		$zipError = null;
		$phoneError = null;
		$hoursError = null;
		$accessibilityError = null;
         
        // keep track post values
        $theater_name = $_POST['theater_name'];
        $theater_address = $_POST['theater_address'];
        $theater_city = $_POST['theater_city'];
        $theater_state = $_POST['theater_state'];
		$theater_zip = $_POST['theater_zip'];
		$theater_phone = $_POST['theater_phone'];
		$theater_hours = $_POST['theater_hours'];
		$theater_accessibility = $_POST['theater_accessibility'];
		 
        // validate input
        $valid = true;
        if (empty($theater_name)) {
            $nameError = 'Please enter Name of theater.';
            $valid = false;
        } 
        if (empty($theater_address)) {
            $addressError = 'Please enter address of theater.';
            $valid = false;
        }
        if (empty($theater_city)) {
            $cityError = 'Please enter the city the theater is located in.';
            $valid = false;
        }
		if (empty($theater_state)) {
			$stateError = 'Please enter the state the theater is located in.';
			$valid = false;
		}
		if (empty($theater_zip)) {
			$zipError = 'Please enter the zip code of the theater.';
			$valid = false;
		}
		if (empty($theater_phone)) {
			$phoneError = 'Please enter the phone number for the theater.';
			$valid = false;
		}
		if (empty($theater_hours)) {
			$hoursError = 'Please enter theater hours of operation.';
			$valid = false;
		}
		if (empty($theater_accessibility)) {
			$accessibilityError = 'Please indicate if the theater is handicap accessible.';
			$valid = false;
		}
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO theaters (theater_name,theater_address,theater_city,theater_state,
				    theater_zip, theater_phone, theater_hours, theater_accessibility) values(?, ?, ?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($theater_name,$theater_address,$theater_city,$theater_state,$theater_zip, $theater_phone,
							  $theater_hours, $theater_accessibility));
            Database::disconnect();
            header("Location: theaters_admin.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Theater</h3>
                    </div>

					<!-- Create form to insert theater information -->
                    <form class="form-horizontal" action="create_theater.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name:</label>
                        <div class="controls">
                            <input name="theater_name" type="text"  placeholder="Name" value="<?php echo !empty($theater_name)?$theater_name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($addressError)?'error':'';?>">
                        <label class="control-label">Address:</label>
                        <div class="controls">
                            <input name="theater_address" type="text" placeholder="Address" value="<?php echo !empty($theater_address)?$theater_address:'';?>">
                            <?php if (!empty($addressError)): ?>
                                <span class="help-inline"><?php echo $addressError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($cityError)?'error':'';?>">
                        <label class="control-label">City:</label>
                        <div class="controls">
                            <input name="theater_city" type="text"  placeholder="City" value="<?php echo !empty($theater_city)?$theater_city:'';?>">
                            <?php if (!empty($cityError)): ?>
                                <span class="help-inline"><?php echo $cityError;?></span>
                            <?php endif;?>
                        </div>
                      </div>					  
                      <div class="control-group <?php echo !empty($stateError)?'error':'';?>">
                        <label class="control-label">State:</label>
                        <div class="controls">
                            <input name="theater_state" type="text"  placeholder="State" value="<?php echo !empty($theater_state)?$theater_state:'';?>">
                            <?php if (!empty($stateError)): ?>
                                <span class="help-inline"><?php echo $stateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>				
                      <div class="control-group <?php echo !empty($zipError)?'error':'';?>">
                        <label class="control-label">Zip Code:</label>
                        <div class="controls">
                            <input name="theater_zip" type="text"  placeholder="5 Digit Zip Code" value="<?php echo !empty($theater_zip)?$theater_zip:'';?>">
                            <?php if (!empty($zipError)): ?>
                                <span class="help-inline"><?php echo $zipError;?></span>
                            <?php endif;?>
                        </div>
                      </div>					  
                      <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
                        <label class="control-label">Phone Number:</label>
                        <div class="controls">
                            <input name="theater_phone" type="text"  placeholder="Phone Number" value="<?php echo !empty($theater_phone)?$theater_phone:'';?>">
                            <?php if (!empty($phoneError)): ?>
                                <span class="help-inline"><?php echo $phoneError;?></span>
                            <?php endif;?>
                        </div>
                      </div>	  
                      <div class="control-group <?php echo !empty($hoursError)?'error':'';?>">
                        <label class="control-label">Hours of Operation:</label>
                        <div class="controls">
                            <input name="theater_hours" type="text"  placeholder="Hours of Operation" value="<?php echo !empty($theater_hours)?$theater_hours:'';?>">
                            <?php if (!empty($hoursError)): ?>
                                <span class="help-inline"><?php echo $hoursError;?></span>
                            <?php endif;?>
                        </div>
                      </div>				  
                      <div class="control-group <?php echo !empty($accessibilityError)?'error':'';?>">
                        <label class="control-label">Handicap Accessible</label>
                        <div class="controls">
                            <input name="theater_accessibility" type="text"  placeholder="1 for Yes, 2 for No" 
							value="<?php echo !empty($theater_accessibility)?$theater_accessibility:'';?>">
                            <?php if (!empty($accessibilityError)): ?>
                                <span class="help-inline"><?php echo $accessibilityError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
				  
					  <!-- Show Create and Back buttons -->
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="theaters_admin.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>