<!-- Update Movie -->

<?php
	session_start();
	
	//check that user is logged in
	$sess_id = 'loggedin';
	if($_SESSION['user']!=$sess_id)
		header("Location: index.php");

    require 'database.php';

	//get id of movie review is associated with
    $movie_id = null;
	if ( !empty($_GET['movie_id'])) {
	$movie_id = $_REQUEST['movie_id'];
	}
  
    //get id of the review
    $review_id = null;
    if ( !empty($_GET['review_id'])) {
        $review_id = $_REQUEST['review_id'];
    }
	 
    if ( null==$movie_id ) {
        header("Location: error.php");
    }
  
    if ( !empty($_POST)) {
        // keep track validation errors
        $usernameError = null;
        $ratingError = null;
		$descriptionError = null;
         
        // keep track post values
		$review_username = $_POST['review_username'];
		$review_rating = $_POST['review_rating'];
		$review_description = $_POST['review_description'];
		 
        // validate input
        $valid = true;
        if (empty($review_username)) {
            $usernameError = 'Please enter your username.';
            $valid = false;
        } 
        if (empty($review_rating)) {
            $reviewError = 'Please enter your rating (out of 5 stars) for this movie.';
            $valid = false;
        }
        if (empty($review_description)) {
            $descriptionError = 'Please enter a description for why you gave the movie this rating.';
            $valid = false;
        }
         
        // update data
        if ($valid) {			
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE movie_reviews set review_username = ?, review_rating = ?, review_description = ?, movie_id = ? WHERE review_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($review_username, $review_rating, $review_description, $movie_id, $review_id));
            Database::disconnect();
			header("Location: movie_reviews_user.php?movie_id=$movie_id");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM movie_reviews where review_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($review_id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
		$review_username = $data['review_username'];
		$review_rating = $data['review_rating'];
		$review_description = $data['review_description'];
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
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update a Review</h3>
                    </div>
             
					<!-- show form to update information for review -->
                    <form class="form-horizontal" action="update_review.php?movie_id=<?php echo $movie_id?>&review_id=<?php echo $review_id?>" method="post">
                      <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
                        <label class="control-label">Username:</label>
                        <div class="controls">
                            <input name="review_username" type="text"  placeholder="Username" value="<?php echo !empty($review_username)?$review_username:'';?>">
                            <?php if (!empty($usernameError)): ?>
                                <span class="help-inline"><?php echo $usernameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
						<!-- show a drop down menu for the 5 star rating -->
                        <label class="control-label">5 Star Rating</label>
                        <div class="controls">
							<select name="review_rating">
								<option value='0'>0</option>
								<option value='1'>1</option>
								<option value='2'>2</option>
								<option value='3'>3</option>
								<option value='4'>4</option>
								<option value='5'>5</option>
							</select>
                            <?php if (!empty($ratingError)): ?>
                                <span class="help-inline"><?php echo $ratingError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <input name="review_description" type="text"  placeholder="Description" value="<?php echo !empty($review_description)?$review_description:'';?>">
                            <?php if (!empty($descriptionError)): ?>
                                <span class="help-inline"><?php echo $descriptionError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  					  
					  <!-- show update and back buttons -->
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="movie_reviews_user.php?movie_id= $movie_id">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>



