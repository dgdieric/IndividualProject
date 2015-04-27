<!-- Admin: Delete Movie -->

<?php
	//check that admin is logged in
	session_start();
	$sess_id = 'loggedin';
	if($_SESSION['admin']!=$sess_id)
		header("Location: index.php");

    require 'database.php';
     
	//get id of theater movie is associated with
    if ( !empty($_GET['theater_id'])) {
        $theater_id = $_REQUEST['theater_id'];
    }
	
	//get id of movie
	if ( !empty($_GET['movie_id'])) {
		$movie_id = $_REQUEST['movie_id'];
	}
	
    if ( !empty($_POST)) {
        // keep track post values
        $movie_id = $_POST['movie_id'];
		 
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM theater_movies  WHERE movie_id = ?" ;
        $q = $pdo->prepare($sql);
        $q->execute(array($movie_id));
        Database::disconnect();
        header("Location: theater_movies_admin.php?theater_id=$theater_id");
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
                        <h3>Delete a Movie</h3>
                    </div>

					<!-- Ask admin if they really want to delete -->
                    <form class="form-horizontal" action="delete_movie.php?theater_id=<?php echo $theater_id?>&movie_id=<?php echo $movie_id?>" method="post">
                      <input type="hidden" name="movie_id" value="<?php echo $movie_id;?>"/>
                      <p class="alert alert-error">Are you sure you want to delete?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="theater_movies_admin.php?theater_id=$theater_id">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>