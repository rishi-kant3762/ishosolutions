<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
$result = "";
$colname_qLoginID = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_qLoginID = $_SESSION['MM_Username'];
}
$query_qLoginID = "SELECT loginID, emailID, password FROM login WHERE emailID = '$colname_qLoginID'";
$qLoginID = mysqli_query($conn, $query_qLoginID);
$row_qLoginID = mysqli_fetch_assoc($qLoginID);
$totalRows_qLoginID = mysqli_num_rows($qLoginID);

$oldpassworddb = $row_qLoginID['password'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "changePassword")) {
	
	if($oldpassworddb == $_POST['oldPassword'])
	{
		if($_POST['password'] == $_POST['rPassword'] )
		{
	
		  $password = $_POST['password'];
		  $loginID = $_POST['loginID'];
		  $updateSQL = "UPDATE login SET password='$password' WHERE loginID='$loginID'";
		
		  $Result1 = mysqli_query($conn, $updateSQL);
		
		  $updateGoTo = "login.php?Sucessfully";
		  if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		  }
		}
		else
		{
			$result = "(Kindly Use Same Password for Change)";
		}
	}
	else
	{
		$result = "(Old Password is not correct)";
	}
  header(sprintf("Location: %s", $updateGoTo));
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Change Password</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>

  <body>
  <!-- container section start -->
  <section id="container" class="">
      <!--header start-->
      <?php include("header.php"); ?>      
      <!--header end-->

      <!--sidebar start-->
      <?php include("left-side.php"); ?>
      <!--sidebar end-->

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
		  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-unlock" aria-hidden="true"></i> Change Password</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
						<li><i class="fa fa-unlock" aria-hidden="true"></i>Change Password</li>
					</ol>
				</div>
			</div>
              <!-- Form validations -->              
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Change Password  <?php echo $result; ?>
                          </header>
                          <div class="panel-body">
                              <div class="form">
                                  <form name="changePassword" class="form-validate form-horizontal" method="POST" action="<?php echo $editFormAction; ?>">
                                      <div class="form-group ">
                                          <label for="cname" class="control-label col-lg-2">Old Password <span class="required">*</span></label>
                                          <div class="col-lg-6">
                                              <input class="form-control" id="cname" name="oldPassword" type="password" required />
                                          </div>
                                      </div>
                                      <div class="form-group ">
                                          <label for="cemail" class="control-label col-lg-2">New Password <span class="required">*</span></label>
                                          <div class="col-lg-6">
                                              <input class="form-control " id="cemail" type="text" minlength="6"  name="password" required />
                                          </div>
                                      </div>
                                      <div class="form-group ">
                                          <label for="curl" class="control-label col-lg-2">Repeat Password</label>
                                          <div class="col-lg-6">
                                              <input class="form-control " id="curl" type="password" minlength="6"  name="rPassword" />
                                          </div>
                                      </div>
                                      
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <input value="Change" class="btn btn-primary" type="submit">
                                              <button class="btn btn-default" type="button">Cancel</button>
                                              <input name="loginID" type="hidden" id="loginID" value="<?php echo $row_qLoginID['loginID']; ?>">
                                            
                                          </div>
                                      </div>
                                      <input type="hidden" name="MM_update" value="feedback_form">
                                      <input type="hidden" name="MM_update" value="changePassword">
                                  </form>
                              </div>

                          </div>
                      </section>
                  </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section end -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- jquery validate js -->
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>

    <!-- custom form validation script for this page-->
    <script src="js/form-validation-script.js"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>    


  </body>
</html>