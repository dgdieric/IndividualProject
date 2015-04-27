<!-- Admin: Reviews -->

<?php 
    require 'database.php';

	//get id of movie review is associated with
    if ( !empty($_GET['movie_id'])) {
        $movie_id = $_REQUEST['movie_id'];
    }
     
    if ( null==$movie_id ) {
        header("Location: error.php");
    } else {
		//select reviews with the specified movie id
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM movie_reviews WHERE movie_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($movie_id));
        $data = $q->fetchAll(PDO::FETCH_ASSOC);
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
            <div class="row">
			    
				<?php 
				$pdo2 = Database::connect();
                $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sqlName = "SELECT movie_name FROM theater_movies WHERE movie_id = ?";
                $q2 = $pdo2->prepare($sqlName);
                $q2->execute(array($movie_id));
                $data2 = $q2->fetchAll(PDO::FETCH_ASSOC);
		
				//show header with the movie name
                echo "<h3>Reviews for " .$data2[0]['movie_name']." </h3>";
				?>
            </div>
            <div class="row">
				<!-- show logout button -->
                <p>
					<a href="logout.php" class="btn btn-danger">Logout</a>
                </p> 
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>Star Rating</th>
                          <th>Description</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
					    //check that admin is logged in
					    session_start();
						$sess_id="loggedin";
						if($_SESSION["admin"]!=$sess_id){
							header("Location: index.php");
						}
	
						$keys = array_keys($data[0]);
						$iterations = count($data);
						
						//show all reviews for the movie with the specified id
						for ($i = 0; $i < $iterations; $i++ ) {							
                                echo '<tr>';
                                echo '<td width=425>'. $data[$i]['review_username'] . '</td>';
                                echo '<td width=100>'. $data[$i]['review_rating'] . '</td>';
                                echo '<td width=600>'. $data[$i]['review_description'] . '</td>';
								
								echo '<td width=500>';
								//show button to read the review
                                echo '<a class="btn" href="read_review.php?review_id='.$data[$i]['review_id'].'">Read</a>';
								echo ' ';
								//show button to delete the review
                                echo '<a class="btn btn-danger" href="delete_review.php?movie_id= '.$movie_id.'&review_id='.$data[$i]['review_id'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>
