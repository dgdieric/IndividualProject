<!-- Update Movie -->

<?php
	session_start();
	
	//check that admin is logged in
	$sess_id = 'loggedin';
	if($_SESSION['admin']!=$sess_id)
		header("Location: index.php");

    require 'database.php';

	//get id for theater movie is associated with
    $theater_id = null;
	if ( !empty($_GET['theater_id'])) {
	$theater_id = $_REQUEST['theater_id'];
	}
  
    //get id of the movie
    $movie_id = null;
    if ( !empty($_GET['movie_id'])) {
        $movie_id = $_REQUEST['movie_id'];
    }
	 
    if ( null==$movie_id ) {
        header("Location: error.php");
    }
  
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $ratingError = null;
		$descriptionError = null;
		$lengthError = null;
		$showtimesError = null;
         
        // keep track post values
		$movie_name = $_POST['movie_name'];
		$movie_rating = $_POST['movie_rating'];
		$movie_description = $_POST['movie_description'];
		$movie_length = $_POST['movie_length'];
		$movie_showtimes = $_POST['movie_showtimes'];
		 
        // validate input
        $valid = true;
        if (empty($movie_name)) {
            $nameError = 'Please enter Name of movie.';
            $valid = false;
        } 
        if (empty($movie_rating)) {
            $ratingError = 'Please enter the viewing rating for the movie.';
            $valid = false;
        }
        if (empty($movie_description)) {
            $descriptionError = 'Please enter a description of the movie.';
            $valid = false;
        }
		if (empty($movie_length)) {
			$lengthError = 'Please enter the length of the movie.';
			$valid = false;
		}
		if (empty($movie_showtimes)) {
			$showtimesError = 'Please enter the showtimes for this movie.';
			$valid = false;
		}
         
        // update data
        if ($valid) {			
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE theater_movies set movie_name = ?, movie_rating = ?, movie_description = ?, movie_length = ?, 
					movie_showtimes = ? WHERE movie_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($movie_name, $movie_rating, $movie_description, $movie_length,
								$movie_showtimes, $movie_id));
            Database::disconnect();
			header("Location: theater_movies_admin.php?theater_id=$theater_id");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM theater_movies where movie_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($movie_id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
		$movie_name = $data['movie_name'];
		$movie_rating = $data['movie_rating'];
		$movie_description = $data['movie_description'];
		$movie_length = $data['movie_length'];
		$movie_showtimes = $data['movie_showtimes'];
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
                        <h3>Update a Movie</h3>
                    </div>
					
					<!-- sohw form to update information for the movie -->
                    <form class="form-horizontal" action="update_movie.php?theater_id=<?php echo $theater_id?>&movie_id=<?php echo $movie_id?>" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name:</label>
                        <div class="controls">
                            <input name="movie_name" type="text"  placeholder="Name" value="<?php echo !empty($movie_name)?$movie_name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
                        <label class="control-label">Rating:</label>
                        <div class="controls">
                            <input name="movie_rating" type="text" placeholder="Viewing Rating" value="<?php echo !empty($movie_rating)?$movie_rating:'';?>">
                            <?php if (!empty($ratingError)): ?>
                                <span class="help-inline"><?php echo $ratingError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <input name="movie_description" type="text"  placeholder="Description" value="<?php echo !empty($movie_description)?$movie_description:'';?>">
                            <?php if (!empty($descriptionError)): ?>
                                <span class="help-inline"><?php echo $descriptionError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($lengthError)?'error':'';?>">
                        <label class="control-label">Running Time:</label>
                        <div class="controls">
                            <input name="movie_length" type="text"  placeholder="Length of movie in minutes" value="<?php echo !empty($movie_length)?$movie_length:'';?>">
                            <?php if (!empty($lengthError)): ?>
                                <span class="help-inline"><?php echo $lengthError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($showtimesError)?'error':'';?>">
                        <label class="control-label">Showtimes:</label>
                        <div class="controls">
                            <input name="movie_showtimes" type="text"  placeholder="Showtimes" value="<?php echo !empty($movie_showtimes)?$movie_showtimes:'';?>">
                            <?php if (!empty($showtimesError)): ?>
                                <span class="help-inline"><?php echo $showtimesError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  					  
					  <!-- show update and back button -->
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="theaters_admin.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>

