<?php require_once('Connections/conn.php'); ?>
<?php
session_start();

$colname_qMyProfile = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_qMyProfile = $_SESSION['MM_Username'];
}
$query_qMyProfile = "SELECT * FROM login WHERE emailID = '$colname_qMyProfile'";
$qMyProfile = mysqli_query($conn, $query_qMyProfile);
$row_qMyProfile = mysqli_fetch_assoc($qMyProfile);
$totalRows_qMyProfile = mysqli_num_rows($qMyProfile);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>My Profile</title>

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
					<h3 class="page-header"><i class="icon_profile"></i> My Profile</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
						<li><i class="icon_profile"></i>My Profile</li>
					</ol>
				</div>
			</div>
              
            
            <div class="col-lg-12">
                      <!--Project Activity start-->
                      <section class="panel">
                          
                        <table class="table table-hover personal-task">
                <tr>
                    <td><strong>User Name</strong></td>
                    <td><?php echo $row_qMyProfile['emailID']; ?></td>
                    <td><strong>Password</strong></td>
                    <td><?php echo $row_qMyProfile['password']; ?></td>
                </tr>
                <tr><td colspan="4" class="span" style="text-align:center;">Basic Personal Information</td></tr>
                <tr>
                    <td><strong>Full Name</strong></td>
                    <td><?php echo $row_qMyProfile['name']; ?></td>
                  	<td><strong>Alternate Mobile</strong></td>
                    <td><?php echo $row_qMyProfile['mobile']; ?></td>
                </tr>
              
            </table>
                          
                          
                      </section>
                      <!--Project Activity end-->
                  </div>
            
            
            
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
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script><!--custome script for all page-->
    <script src="js/scripts.js"></script>


  </body>
</html>