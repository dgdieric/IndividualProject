<!-- User: Delete Review -->

<?php
	session_start();
	$sess_id = 'loggedin';
	if($_SESSION['user']!=$sess_id)
		header("Location: index.php");

    require 'database.php';
     
	//get id of movie review is associated with 
    if ( !empty($_GET['movie_id'])) {
        $movie_id = $_REQUEST['movie_id'];
    }
	
	//get id of review
	if ( !empty($_GET['review_id'])) {
		$review_id = $_REQUEST['review_id'];
	}
	
    if ( !empty($_POST)) {
        // keep track post values
        $review_id = $_POST['review_id'];
		 
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM movie_reviews WHERE review_id = ?" ;
        $q = $pdo->prepare($sql);
        $q->execute(array($review_id));
        Database::disconnect();
        header("Location: movie_reviews_user.php?movie_id=$movie_id");
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
                        <h3>Delete a Review</h3>
                    </div>

					<!-- Ask user if they really want to delete the review -->
                    <form class="form-horizontal" action="delete_review_user.php?movie_id=<?php echo $movie_id?>&review_id=<?php echo $review_id?>" method="post">
                      <input type="hidden" name="review_id" value="<?php echo $review_id;?>"/>
                      <p class="alert alert-error">Are you sure you want to delete?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="movie_reviews_admin.php?movie_id=$movie_id">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
