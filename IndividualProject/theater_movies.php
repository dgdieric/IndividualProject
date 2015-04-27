<!-- Movies -->

<?php 
    require 'database.php';
    $id = null;
	
	//get id of theater
    if ( !empty($_GET['theater_id'])) {
        $id = $_REQUEST['theater_id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
		//select movies with specified theater id
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM theater_movies WHERE theater_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
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
                $sqlName = "SELECT theater_name FROM theaters WHERE theater_id = ?";
                $q2 = $pdo2->prepare($sqlName);
                $q2->execute(array($id));
                $data2 = $q2->fetchAll(PDO::FETCH_ASSOC);
		
				//show header with theater name
                echo "<h3>Movies at " .$data2[0]['theater_name']." </h3>";
				?>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Movie</th>
                          <th>Rating</th>
                          <th>Description</th>
						  <th>Length</th>
                          <th>Show Times</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
						$keys = array_keys($data[0]);
						$iterations = count($data);
						
						//show all movies with specified theater id
						for ($i = 0; $i < $iterations; $i++ ) {
                                echo '<tr>';
                                echo '<td width=425>'. $data[$i]['movie_name'] . '</td>';
                                echo '<td width=100>'. $data[$i]['movie_rating'] . '</td>';
                                echo '<td width=600>'. $data[$i]['movie_description'] . '</td>';
								echo '<td width=100>'. $data[$i]['movie_length'] . '</td>';
								echo '<td width=400>'. $data[$i]['movie_showtimes'] . '</td>';
								
								echo '<td width=500>';
								//show button to read a movie
                                echo '<a class="btn" href="read_movie.php?movie_id='.$data[$i]['movie_id'].'">Read</a>';
								echo ' ';
								//show button to view reviews for the movie
                                echo '<a class="btn" href="movie_reviews.php?movie_id='.$data[$i]['movie_id'].'">Reviews</a>';
                                echo ' ';
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