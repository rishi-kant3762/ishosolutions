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

function RemoveSpecialChar($str) {

  $res = str_replace( array( '\'', '"',
  ',' , ';', '<', '>', '/', '@', '\\', '*', '$', '& ', '%', '(', ')'), '', $str);

  $res = str_replace(' ', '-', $res);
  return strtolower($res);
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

$query_qViewAllCustomer = "SELECT * FROM registration ORDER BY id DESC";
$qViewAllCustomer = mysqli_query($conn, $query_qViewAllCustomer);
$row_qViewAllCustomer = mysqli_fetch_assoc($qViewAllCustomer);
$totalRows_qViewAllCustomer = mysqli_num_rows($qViewAllCustomer);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>All Customer Details</title>

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
					<h3 class="page-header"><i class="fa fa-user" aria-hidden="true"></i> All Customer Details</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php"> Home</a></li>
						<li><i class="fa fa-user" aria-hidden="true"></i> All Customer Details</li>
					</ol>
				</div>
			</div>
              <!-- page start-->
              <div class="col-lg-12">
              <?php
			  if($totalRows_qViewAllCustomer != 0)
			  {
				  ?>
                <section class="panel">
                 
                          
                    <table class="table table-striped table-advance table-hover">
                        <tbody>
                          <tr>
                            <th width="15%"> Customer Name</th>
                            <th width="10%"> District</th>
                            <th width="15%"> Picture</th>
                            <th width="15%"> Mobile</th>
                            <th width="25%"> Date Of Creation</th>
                            <th width="20%"><i class="icon_cogs"></i> Action</th>
                          </tr>
						<?php do { 
						
						$status = $row_qViewAllCustomer['status'];
						?>
                          <tr>
                        <td><?php echo $row_qViewAllCustomer['name']; ?></td>
                        <td><?php echo $row_qViewAllCustomer['district']; ?></td>
                        <td><img src="customer/<?php echo $row_qViewAllCustomer['picture']; ?>" style="width: 100px; height: 100px;"></td>
                        <td><?php echo $row_qViewAllCustomer['contact']; ?></td>
                        <td><?php echo substr($row_qViewAllCustomer['DateOfReg'], 0, 20); ?></td>
                        <td>
                          <div class="btn-group">
                              <?php
                              if($status == 0)
                              {?>
                            <a class="btn btn-danger" title="Activate Now" href="activateCard.php?id=<?php echo $row_qViewAllCustomer['id']; ?>"><i class="fa fa-check-square" aria-hidden="true"></i></a>
                                <?php
                              }
                              else
                              {
                                  ?>
                                  
                                  
                            <a target="_blank" class="btn btn-info" href="card/card.php?id=<?php echo $row_qViewAllCustomer['id']; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                            <a  target="_blank" class="btn btn-success" href="card/download.php?id=<?php echo $row_qViewAllCustomer['id']; ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
                            
                                <?php
                              }
                              ?>
                            <a class="btn btn-primary" href="viewCustomer.php?id=<?php echo $row_qViewAllCustomer['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-success" href="editCustomer.php?id=<?php echo $row_qViewAllCustomer['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            
                          </div>
                        </td>
                        
                       </tr>
                        <?php } while ($row_qViewAllCustomer = mysqli_fetch_assoc($qViewAllCustomer)); ?>

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
