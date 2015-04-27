<!-- Read movie -->

<?php
    require 'database.php';
    $id = null;
	
	//get id of the movie
    if ( !empty($_GET['movie_id'])) {
        $id = $_REQUEST['movie_id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
		//select movie with the specified id
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM theater_movies WHERE movie_id = ?";
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
     
				<!-- Show movie information -->
                <div class="span10 offset1">
                    <div class="row">
                        <h3><?php echo $data['movie_name']; ?></h3>
                    </div>                     
                    <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Rating:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['movie_rating'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Description:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['movie_description'];?>
                            </label>
                        </div>
                      </div>
					  
                      <div class="control-group">
                        <label class="control-label">Length:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['movie_length'];?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Showtimes:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['movie_showtimes'];?>
                            </label>
                        </div>
                      </div>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
