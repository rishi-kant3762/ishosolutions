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
?>
<?php

$colname_qViewBlogPost = "-1";
if (isset($_GET['id'])) {
  $colname_qViewBlogPost = $_GET['id'];
}
$query_qViewBlogPost = "SELECT * FROM blogpost WHERE postID = '$colname_qViewBlogPost'";
$qViewBlogPost = mysqli_query($conn, $query_qViewBlogPost);
$row_qViewBlogPost = mysqli_fetch_assoc($qViewBlogPost);
$totalRows_qViewBlogPost = mysqli_num_rows($qViewBlogPost);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>View Blog Post</title>

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
					<h3 class="page-header"><i class="fa fa-th-large" aria-hidden="true"></i> View Blog</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
						<li><i class="fa fa-th-large" aria-hidden="true"></i> View Blog</li>
					</ol>
				</div>
			</div>
              
            
            <div class="col-lg-12">
                      <!--Project Activity start-->
                      <section class="panel">
                          
                        <table class="table table-hover personal-task">
                            <tr>
                                <td width="20%">Date (Post By) - Edit</td>
                                <td width="80%"><?php echo $row_qViewBlogPost['postDate']; ?> (<?php echo $row_qViewBlogPost['userLoginID']; ?>) - <a href="editBlogPost.php?id=<?php echo $_GET['id']; ?>">Edit</a></td>
                            </tr>
                            <tr>
                                <td>Post URL</td>
                                <td><?php echo $row_qViewBlogPost['postUrl']; ?></td>
                            </tr>
                            <tr>
                                <td>Post Title</td>
                                <td><?php echo $row_qViewBlogPost['postTitle']; ?></td>
                            </tr>
                            <tr>
                                <td>Post Keywords</td>
                                <td><?php echo $row_qViewBlogPost['postKeywords']; ?></td>
                            </tr>
                            <tr>
                                <td>Post Meta Des</td>
                                <td><?php echo $row_qViewBlogPost['postMetaDes']; ?></td>
                            </tr>
                            <tr>
                                <td>Post Name</td>
                                <td><?php echo $row_qViewBlogPost['postName']; ?></td>
                            </tr>
                            <tr>
                                <td>Image</td>
                                <td><img src="blog-image/<?php echo $row_qViewBlogPost['postImg']; ?>" height="100" width="50%"></td>
                            </tr>
                            <tr>
                                <td>Post Description</td>
                                <td><?php echo $row_qViewBlogPost['postDes']; ?></td>
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