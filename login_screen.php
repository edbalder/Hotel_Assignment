<?php  
     
    session_start(); 
     
    # include connection data and functions 
    require 'database.php'; 
     
    # if there was data passed, then verify password,  
    # otherwise do nothing (that is, just display html for login) 
    if ( !empty($_POST)) { 
        // keep track validation errors 
        $passwordError = null; 
         
        // keep track post values 
        $password = $_POST['password']; 
         
        // validate input 
        $valid = true; 
         
        if (empty($password)) { 
            $passwordError = 'Please enter password'; 
            $valid = false; 
        }  
         
        // verify that password is correct
        if ($valid) { 
            $pdo = Database::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "SELECT * FROM employees WHERE password = ? LIMIT 1"; 
            $q = $pdo->prepare($sql); 
            $q->execute(array($password)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
            if($results['password']==$password) { 
                $_SESSION['emp_id'] = $results['password']; 
                Database::disconnect(); 
                header("Location: main_menu.php"); // redirect 
            } 
            else { 
                $passwordError = 'Password is not valid'; 
                Database::disconnect(); 
            } 
        } 
    } # end if ( !empty($_POST)) 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
</head> 

<body> 
    <div class="container"> 
     
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Login</h3> 
                    </div> 
             
                    <form class="form-horizontal" action="login_screen.php" method="post"> 
                      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>"> 
                        <label class="control-label">Password</label> 
                        <div class="controls"> 
						Use "1234"
                              <input name="password" type="password" placeholder="password" value="<?php echo !empty($password)?$password:'';?>"> 
                              <?php if (!empty($passwordError)): ?> 
                                  <span class="help-inline"><?php echo $passwordError;?></span> 
                              <?php endif;?> 
                        </div> 
                      </div> 
                       
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-success">Log In</button> 
                          <a class="btn" href="main_menu.php">Back</a> 
                      </div> 
                         
                    </form> 
                     
                </div> 
                 
    </div> <!-- /container -->  
  </body> 
</html> 