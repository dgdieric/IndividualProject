<!-- User: Create Review -->

<?php
	//check that user is logged in
	session_start();
	$sess_id = 'loggedin';
	if($_SESSION['user']!=$sess_id)
		header("Location: index.php");
	
    if ( !empty($_GET['movie_id'])) {
        $id = $_REQUEST['movie_id'];
    }
	
    require 'database.php';
 
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
		
        // insert data
        if ($valid) {		
			var_dump($id);
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO movie_reviews (review_username, review_rating, review_description, movie_id)
					VALUES (?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($review_username, $review_rating, $review_description, $id));
            Database::disconnect();
            header("Location: movie_reviews_user.php?movie_id= $id");
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
                        <h3>Create a Review</h3>
                    </div>
					<!-- Create form to insert review information -->
                    <form class="form-horizontal" action="create_review.php?movie_id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
                        <label class="control-label">Username:</label>
                        <div class="controls">
                            <input name="review_username" type="text"  value="user" readonly>
                            <?php if (!empty($usernameError)): ?>
                                <span class="help-inline"><?php echo $usernameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
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
                        <label class="control-label">Description:</label>
                        <div class="controls">
                            <input name="review_description" type="text"  placeholder="Description" value="<?php echo !empty($review_description)?$review_description:'';?>">
                            <?php if (!empty($descriptionError)): ?>
                                <span class="help-inline"><?php echo $descriptionError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>


