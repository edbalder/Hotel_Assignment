<?php
	include 'database.php';
	session_start();
	if (empty($_SESSION['emp_id'])){
		echo 'user not set';
		//login();
		exit();
	}
	
    $SelectedGuestId = null;
    if ( !empty($_GET['SelectedGuestId'])) {
        $SelectedGuestId = $_REQUEST['SelectedGuestId'];
    }
	
	$SelectedFloor = null;
	if(!empty($_GET['SelectedFloor'])) {
		$SelectedFloor = $_REQUEST['SelectedFloor'];
	}
     
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($SelectedRoomId)); 
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $RoomNumber = $data['room_number'];
	$RoomBeds = $data['beds'];
	Database::disconnect();
	
	$pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM guests WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($SelectedGuestId)); 
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $GuestName = $data['name'];
	$GuestCCNumber = $data['cardNumber'];
	$GuestIdNumber = $data['memberid'];
	$GuestPhoneNumber = $data['phoneNumber'];
	Database::disconnect();
	
	if(!empty($_POST)){
		$numberOfGuests = $_POST['numberOfGuests'];
		$SelectedRoomId = $_POST['theRoom'];
		print_r([$SelectedGuestId,$SelectedRoomId,$numberOfGuests]);
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO transactions (guestId,roomId,numberOfGuests) values(?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($SelectedGuestId,$SelectedRoomId,$numberOfGuests));
        Database::disconnect();
        header("Location: main_menu.php");
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Transaction Details</h3>
                    </div>
                    <form class="form-horizontal" action="" method="post">
						<div class="form-horizontal" >
						<div class="control-group">
							<label class="control-label">Guest</label>
							<div class="controls">
								<p name="theName">
									<?php echo $GuestName;?>
									<a class="btn" href="sale_menu.php">    Change Customer</a>
								</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Credit Card Number</label>
							<div class="controls">
								<p name="theCCNumber">
									<?php echo $GuestCCNumber;?>
								</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Mobile Number</label>
							<div class="controls">
								<p name="thePhoneNumber">
									<?php echo $GuestPhoneNumber;?>
								</p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Room Number</label>
							<div class="controls">
								<select name="theRoom">	
									<?php
									$pdo = Database::connect();
									$sql = "SELECT * FROM rooms WHERE floor = '".$SelectedFloor."' ORDER BY room_number ASC";
									foreach ($pdo->query($sql) as $row) {
									echo '<option value="'.$row['room_id'].'">'.$row['room_number'].' '.$row['roomType'].' Beds: '.$row['beds'].'</option>';
									}
									Database::disconnect();
									?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Number of Guests DropDown</label>
							<div class="controls">
								<select name="numberOfGuests" >
									<option> 1 </option>
									<option> 2 </option>
									<option> 3 </option>
									<option> 4 </option>
								</select>
								</br>
							</div>
						</div>
						
							<div class="form-actions">
								<button type="submit" class="btn btn-success">Confirm</button>
								<a class="btn" href="main_menu.php">Cancel</a>
							</div>
						
                     </form>
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>