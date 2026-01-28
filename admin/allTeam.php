<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "0";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

$query_qViewAllTeam = "SELECT * FROM team ORDER BY teamID DESC";
$qViewAllTeam = mysqli_query($conn, $query_qViewAllTeam);
$row_qViewAllTeam = mysqli_fetch_assoc($qViewAllTeam);
$totalRows_qViewAllTeam = mysqli_num_rows($qViewAllTeam);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>All Team Details</title>

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
					<h3 class="page-header"><i class="fa fa-user" aria-hidden="true"></i> All Team Details</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php"> Home</a></li>
						<li><i class="fa fa-user" aria-hidden="true"></i> All Team Details</li>
					</ol>
				</div>
			</div>
              <!-- page start-->
              <div class="col-lg-12">
              <?php
			  if($totalRows_qViewAllTeam != 0)
			  {
				  ?>
                <section class="panel">
                 
                          
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                          <tr>
                            <th width="20%"> Name</th>
                            <th width="20%"> Designation</th>
                            <th width="20%"> Mobile</th>
                            <th width="20%"> Picture</th>
                            <th width="20%"><i class="icon_cogs"></i> Action</th>
                          </tr>
						<?php do { ?>
                          <tr>
                        <td><?php echo $row_qViewAllTeam['name']; ?></td>
                        <td><?php echo $row_qViewAllTeam['designation']; ?></td>
                        <td><?php echo $row_qViewAllTeam['mobile']; ?></td>
                        <td><img src="team/<?php echo $row_qViewAllTeam['picture']; ?>" style="width: 50px; height: 50px;"></td>
                        <td>
                          <div class="btn-group">
                            <a class="btn btn-primary" href="viewTeam.php?id=<?php echo $row_qViewAllTeam['teamID']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-success" href="editTeam.php?id=<?php echo $row_qViewAllTeam['teamID']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          </div>
                        </td>
                        
                       </tr>
                        <?php } while ($row_qViewAllTeam = mysqli_fetch_assoc($qViewAllTeam)); ?>

                        </tbody>
                    </table>

                    
                </section>
                <?php
			  }
			  else
			  {
				  ?>
                <h2>No Result Found</h2>
                  <?php
			  }
			  ?>
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
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script><!--custome script for all page-->
    <script src="js/scripts.js"></script>
  </body>
</html>
