<!-- Read Review -->

<?php
    require 'database.php';
    $id = null;
	
	//get id of the review
    if ( !empty($_GET['review_id'])) {
        $id = $_REQUEST['review_id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
		//select review with the specified id
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM movie_reviews WHERE review_id = ?";
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
     
				<!-- Show review information -->
                <div class="span10 offset1">
                    <div class="row">
                        <h3><?php echo $data['review_username']; ?>'s Review</h3>
                    </div>                     
                    <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Rating:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['review_rating'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Description:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['review_description'];?>
                            </label>
                        </div>
                      </div>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
