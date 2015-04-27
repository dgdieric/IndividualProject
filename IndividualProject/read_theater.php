<!-- Read Theater -->

<?php
    require 'database.php';
    $id = null;
	
	//get id of the theater
    if ( !empty($_GET['theater_id'])) {
        $id = $_REQUEST['theater_id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
		//select theater with the specified id
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM theaters WHERE theater_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
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
     
				<!-- Show theater information -->
                <div class="span10 offset1">
                    <div class="row">
                        <h3><?php echo $data['theater_name']; ?></h3>
                    </div>
                    <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Address:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['theater_address'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">City:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['theater_city'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">State:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['theater_state'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Zip Code:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['theater_zip'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Phone Number:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['theater_phone'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Hours of Operation:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['theater_hours'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Handicap Accessibility:</label>
                        <div class="controls">
                            <label class="checkbox">
								<?php
								//show yes or no for handicap accessibility
								if($data['theater_accessibility'] == 1)
									$handicap = 'Yes';
								else
									$handicap = 'No';
							
                                echo $handicap;
								?>
                            </label>
                        </div>
                      </div>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>