<?php
	include 'database.php';
	session_start();
	if (empty($_SESSION['emp_id'])){
		echo 'user not set';
		header('Location: login_screen.php');
		exit();
	}
	$SelectedGuestId = null;
    if ( !empty($_GET['SelectedGuestId'])) {
        $SelectedGuestId = $_REQUEST['SelectedGuestId'];
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
                <h3>Select Room</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Room Number</th>
                      <th>Beds</th>
                      <th>Select</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM rooms ORDER BY room_number ASC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['room_number'] . '</td>';
                            echo '<td>'. $row['beds'] . '</td>';
							echo '<td width=250>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="finish_transaction.php?SelectedGuestId='.$SelectedGuestId.'&SelectedRoomId='.$row['room_id'].'">Select</a>';
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