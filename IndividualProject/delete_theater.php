<!-- Admin: Delete Theater -->

<?php
	//check that admin is logged in
	session_start();
	$sess_id = 'loggedin';
	if($_SESSION['admin']!=$sess_id)
		header("Location: index.php");

    require 'database.php';

	//get id of theater
    if ( !empty($_GET['theater_id'])) {
        $id = $_REQUEST['theater_id'];
    }
	 
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
		 
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM theaters  WHERE theater_id = ?" ;
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: theaters_admin.php");
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
                        <h3>Delete a Theater</h3>
                    </div>

					<!-- Ask admin if they really want to delete the theater -->
                    <form class="form-horizontal" action="delete_theater.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-error">Are you sure you want to delete?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="theaters_admin.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>