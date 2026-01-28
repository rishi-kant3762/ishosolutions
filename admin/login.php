<?php require_once('Connections/conn.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['emailID'])) {
  $loginUsername=$_POST['emailID'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "accessValue";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php?Not-Valid";
  $MM_redirecttoReferrer = true;
  	
  $LoginRS__query="SELECT emailID, password, accessValue FROM login WHERE emailID='$loginUsername' AND password='$password'"; 
   
  $LoginRS = mysqli_query($conn, $LoginRS__query);
  $rows_LoginRS = mysqli_fetch_assoc($LoginRS);
  $loginFoundUser = mysqli_num_rows($LoginRS);
  
  if($loginFoundUser)
  {
      $_SESSION['MM_Username'] = $rows_LoginRS['emailID'];
      $_SESSION['MM_UserGroup'] = $rows_LoginRS['accessValue'];	
      
      
      header("Location: " . $MM_redirectLoginSuccess );
  }
  else
  {
      header("Location: " . $MM_redirectLoginFailed );
  }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">

      <form METHOD="POST" name="userlogin" class="login-form" action="<?php echo $loginFormAction; ?>">        
        <div class="login-wrap">
            <p class="login-img"><img src="img/logo.png" class="img-responsive" style="margin:auto"></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="emailID" class="form-control" placeholder="Username" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            
            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            
        </div>
      </form>

    </div>


  </body>
</html>
