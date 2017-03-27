<?php
	include 'database.php';
	session_start();
	if (empty($_SESSION['emp_id'])){
		echo 'user not set';
		header('Location: login_screen.php');
		exit();
	}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
</head> 
	<a href="main_menu.php" class="btn btn-success">Home</a></br>

	<body>
    <div class="container">
            <div class="row">
                <h3>Select Customer</h3>
            </div>
            <div class="row">
				<p>
                    <a href="new_customer.php" class="btn btn-success">Add Customer</a>
                </p>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>ID Number</th>
                      <th>Phone Number</th>
					  <th>Card Number</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM guests ORDER BY name DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['memberid'] . '</td>';
                            echo '<td>'. $row['phoneNumber'] . '</td>';
							echo '<td>'. $row['cardNumber'] . '</td>';
							echo '<td width=250>';
                            echo '<a class="btn" href="edit_customer.php?id='.$row['id'].'">Edit</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="room_search.php?SelectedGuestId='.$row['id'].'">Select</a>';
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