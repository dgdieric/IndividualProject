<!-- Admin: Theaters -->

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
                <h3>Theaters</h3>
            </div>
            <div class="row">
                <p>
					<!-- show button to create a theater -->
                    <a href="create_theater.php" class="btn btn-success">Create Theater</a>
					<!-- show button to logout -->
					<a href="logout.php" class="btn btn-danger">Logout</a>
                </p>
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Theater Name</th>
                          <th>Address</th>
                          <th>City</th>
						  <th>State</th>
                          <th>Zip</th>
						  <th>Phone Number</th>
						  <th>Hours of Operation</th>
						  <th>Handicap Accessibility</th>
						  <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
						//check that admin is logged in
					    session_start();
						$sess_id="loggedin";
						if($_SESSION["admin"]!= $sess_id){
							header("Location: index.php");
						}
						
						include 'database.php';
                        $pdo = Database::connect();
                        $sql = 'SELECT * FROM theaters ORDER BY theater_id DESC';
						//show all theaters
                        foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td width=400>'. $row['theater_name'] . '</td>';
                                echo '<td width=400>'. $row['theater_address'] . '</td>';
                                echo '<td>'. $row['theater_city'] . '</td>';
								echo '<td>'. $row['theater_state'] . '</td>';
								echo '<td>'. $row['theater_zip'] . '</td>';
								echo '<td width=250>'. $row['theater_phone']. '</td>';
								echo '<td width=250>'. $row['theater_hours']. '</td>';
								
								//show yes or no for handicap accessibility
								if($row['theater_accessibility'] == 1)
									$handicap = "Yes";
								else
									$handicap = "No";
								echo '<td>';
								echo $handicap;
								echo '</td>';
								
								echo '<td width=500>';
								//show button to read the theater
                                echo '<a class="btn" href="read_theater.php?theater_id='.$row['theater_id'].'">Read</a>';
								echo ' ';
								//show button to view movies for the theater
                                echo '<a class="btn" href="theater_movies_admin.php?theater_id='.$row['theater_id'].'">Movies</a>';
                                echo ' ';
								//show button to update the theater
                                echo '<a class="btn btn-success" href="update_theater.php?theater_id='.$row['theater_id'].'">Update</a>';
                                echo ' ';
								//show button to delete the theater
                                echo '<a class="btn btn-danger" href="delete_theater.php?theater_id='.$row['theater_id'].'">Delete</a>';
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
