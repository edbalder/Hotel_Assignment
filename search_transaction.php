<?php
	include 'database.php';
	session_start();
	if (empty($_SESSION['emp_id'])){
		echo 'user not set';
		//login();
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
				<h3>Search Transactions</h3>
			</div>
			<div class="row">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
						<th>Transaction Number</th>
						<th>Customer ID</th>
						<th>Customer Name</th>
						<th>Date</th>
						<th>Room Number</th>
						<th>Number of Guests</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$pdo = Database::connect();
					$sql = 'select * 
							from (select transactionNumber, date_time, roomId, name,cardNumber, numberOfGuests 
								from transactions  
								join guests on guestId = guests.id 
								order by transactionNumber ASC) 
							as T  
							join rooms 
							on T.roomId = rooms.room_id';
					foreach ($pdo->query($sql) as $row) {
								echo '<tr>';
								echo '<td>'. $row['transactionNumber'] . '</td>';
								echo '<td>'. $row['cardNumber'] . '</td>';
								echo '<td>'. $row['name'] . '</td>';
								echo '<td>'. $row['date_time'] . '</td>';
								echo '<td>'. $row['room_number'] . '</td>';
								echo '<td>'. $row['numberOfGuests'] . '</td>';
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