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
	
	<?php
		$pdo = Database::connect();
		$sql = "SELECT name FROM employees WHERE password = " . $_SESSION['emp_id'] . " LIMIT 1";
		$results = mysql_query($sql);
		foreach ($pdo->query($sql) as $row){
			echo 'Hello ' . $row['name'] . '</br>';
		}
        Database::disconnect();
    ?>
	<body>
	<div class="container">
		<div class="row">
			<a href="sale_menu.php" class="btn btn-success">Sale</a></br>
			<a href="search_transaction.php" class="btn btn-success">Search Transactions</a></br>
			<a class="btn btn-danger" href="logout.php">Log Out</a> 
		</div>
	</div>
	</body>

</html> 