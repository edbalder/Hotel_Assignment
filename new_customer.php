<?php
	include 'database.php';
	session_start();
	if (empty($_SESSION['emp_id'])){
		echo 'user not set';
		//login();
		exit();
	}
	
	if(!empty($_POST)){
		ini_set('file-uploads',true);
		if($_FILES['customerImage']['size']>0 && $_FILES['customerImage']['size']<2000000){
			$fileName = $_FILES['customerImage']['name'];
			$tempName = $_FILES['customerImage']['tmp_name'];
			$filesize = $_FILES['customerImage']['size'];
			$filetype = $_FILES['customerImage']['type'];
			
			$filetype = (get_magic_quotes_gpc() == 0
				? mysql_real_escape_string($filetype)
				: mysql_real_escape_string(stripslashes($_FILES['customerImage'])));
				
			$fp = fopen($tempName, 'r');
			$content = fread($fp, filesize($tempName));
			$content = addslashes($content);
			
			fclose($fp);
			
			if(!get_magic_quotes_gpc()) {
				$filename = addslashes($filename);
			}
		}
		
		$id = $_POST['id'];
		$cardNumber = $_POST['cardNumber'];
		$phoneNumber = $_POST['phoneNumber'];
		$name = $_POST['name'];
		
		$pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO guests (memberid,cardNumber,phoneNumber,name) values(?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($id,$cardNumber,$phoneNumber,$name));
        Database::disconnect();
        header("Location: sale_menu.php");
	}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
</head> 
<body>
<a href="sale_menu.php" class="btn btn-success">Back</a></br>
    <div class="container">
	
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Customer</h3>
                    </div>
             
                    <form class="form-horizontal" action="new_customer.php" method="post">
                      <div class="control-group">
                        <label class="control-label">ID Number</label>
                        <div class="controls">
                            <input name="id" type="text" maxlength="11" placeholder="ID" value="<?php echo !empty($id)?$id:'';?>">
                        </div>
						
                      </div>
                      <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                        </div>
                      </div>
					  
                      <div class="control-group">
                        <label class="control-label">Card Number</label>
                        <div class="controls">
                            <input name="cardNumber" type="text" maxlength="11"  placeholder="CC Number" value="<?php echo !empty($cardNumber)?$cardNumber:'';?>">
                        </div>
                      </div>
					  
					  <div class="control-group">
                        <label class="control-label">Phone Number</label>
                        <div class="controls">
                            <input name="phoneNumber" type="text" maxlength="11" placeholder="Phone Number" value="<?php echo !empty($phoneNumber)?$phoneNumber:'';?>">
                        </div>
                      </div>
					  
					  <input type="file" name="customerImage" id="customerImage" />
					  </br>
					  
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="sale_menu.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>

</html> 