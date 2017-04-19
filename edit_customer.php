<?php
    require 'database.php';
	
	session_start();
	if (empty($_SESSION['emp_id'])){
		echo 'user not set';
		header('Location: login_screen.php');
		exit();
	}
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: sale_menu.php");
    }
     
    if ( !empty($_POST)) {				
		$idError = null;
		$nameError = null;
		$cardNumberError = null;
		$phoneNumberError = null;
		
		if (!empty($_FILES['customerImage']['size'])){
			
			$fileName = $_FILES['customerImage']['name'];
			$tmpName  = $_FILES['customerImage']['tmp_name'];
			$fileSize = $_FILES['customerImage']['size'];
			$fileType = $_FILES['customerImage']['type'];
			$fileContent = file_get_contents($tmpName);
		}
        
        // keep track post values
        $newid = $_POST['memberid'];
        $name = $_POST['name'];
        $cardNumber = $_POST['cardNumber'];
		$phoneNumber = $_POST['phoneNumber'];
         
		 // validate input
        $valid = true;
        if (empty($id)) {
            $idError = 'Please enter ID';
            $valid = false;
        }
         
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($cardNumber)) {
            $cardNumberError = 'Please enter CC Number';
            $valid = false;
        }
		
		if (empty($phoneNumber)) {
            $phoneNumberError = 'Please enter Phone Number';
            $valid = false;
        }
        
        
        // update data
        if (!empty($_FILES['customerImage']['size'])) {
			
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE guests set memberid = ?, name = ?, cardNumber =?, phoneNumber =?, img_name=?, img_size=?, img_type=?,img_content=? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($newid,$name,$cardNumber,$phoneNumber,$fileName,$fileSize,$fileType,$fileContent,$id));
				Database::disconnect();
				header("Location: sale_menu.php");
			
		} else {
			$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE guests set memberid = ?, name = ?, cardNumber =?, phoneNumber =? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($newid,$name,$cardNumber,$phoneNumber,$id));
				Database::disconnect();
				header("Location: sale_menu.php");
		}
		 
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM guests where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $memberid = $data['memberid'];
        $name = $data['name'];
        $cardNumber = $data['cardNumber'];
		$phoneNumber = $data['phoneNumber'];
		
		$fileName = $data['img_name'];
		echo 'File: '. $fileName . ' initialized';
		$fileSize = $data['img_size'];
		$fileType = $data['img_type'];
		$fileContent = $data['img_content'];
		
		//print_r($data);
        Database::disconnect();
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
                        <h3>Update a Customer</h3>
                    </div>
             
                    <form class="form-horizontal" action="edit_customer.php?id=<?php echo $id?>" method="post" enctype="multipart/form-data">
                      <div class="control-group <?php echo !empty($idError)?'error':'';?>">
                        <label class="control-label">ID</label>
                        <div class="controls">
                            <input name="memberid" type="text"  placeholder="ID" value="<?php echo !empty($memberid)?$memberid:'';?>">
							<?php if (!empty($idError)): ?>
                                <span class="help-inline"><?php echo $idError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
							<?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
					  
                      <div class="control-group <?php echo !empty($cardNumberError)?'error':'';?>">
                        <label class="control-label">Card Number</label>
                        <div class="controls">
                            <input name="cardNumber" type="text"  placeholder="Card Number" value="<?php echo !empty($cardNumber)?$cardNumber:'';?>">
							<?php if (!empty($cardNumberError)): ?>
                                <span class="help-inline"><?php echo $cardNumberError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
					  
					  <div class="control-group <?php echo !empty($phoneNumberError)?'error':'';?>">
                        <label class="control-label">Phone Number</label>
                        <div class="controls">
                            <input name="phoneNumber" type="text"  placeholder="Phone Number" value="<?php echo !empty($phoneNumber)?$phoneNumber:'';?>">
							<?php if (!empty($phoneNumberError)): ?>
                                <span class="help-inline"><?php echo $phoneNumberError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
					  
					  <input type="file" name="customerImage" id="customerImage" />
					  
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="sale_menu.php">Back</a>
                        </div>
                    </form>
					
					<div class='control-group col-md-6'>
					<div class="controls ">
					<?php 
					//if ($data['img_size'] > 0) 
						echo '<img  height=20%; width=60%; src="data:image/jpeg;base64,' . 
							base64_encode( $data['img_content'] ) . '" />'; 
					//else 
						//echo 'No photo on file.';
					?><!-- converts to base 64 due to the need to read the binary files code and display img -->
					</div>
				</div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>