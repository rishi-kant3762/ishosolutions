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

function RemoveSpecialChar($str) {

  $res = str_replace( array( '\'', '"',
  ',' , ';', '<', '>', '/', '@', '\\', '*', '$', '& ', '%', '(', ')'), '', $str);

  $res = str_replace(' ', '-', $res);
  return strtolower($res);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editBlogPost")) {
	
		$uploads_dir = "blog-image";
/*------------------------------------------------------------*/
  $pname1 = $_FILES["image1"]["name"]; 
if($pname1 != "")
{
  
  $tname1=$_FILES["image1"]["tmp_name"];
  $name1 = pathinfo($_FILES['image1']['name'], PATHINFO_FILENAME);
  $extension1 = pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
   $increment1 = 0; 
   $pname1 = $name1 . '.' . $extension1;
   while(is_file($uploads_dir.'/'.$pname1)) {
     $increment1++;
     $pname1 = $name1 . $increment1 . '.' . $extension1;
   }
   move_uploaded_file($tname1, $uploads_dir.'/'.$pname1);

}
else
{
	$pname1 = $_POST['picture'];
}

    $postID=mysqli_real_escape_string($conn,$_POST['postID']);
    $postName=mysqli_real_escape_string($conn,$_POST['postName']);
    $postDes=mysqli_real_escape_string($conn,$_POST['postDes']);
    $postTitle=mysqli_real_escape_string($conn,$_POST['postTitle']);
    $postKeywords=mysqli_real_escape_string($conn,$_POST['postKeywords']);
    $postMetaDes=mysqli_real_escape_string($conn,$_POST['postMetaDes']);
    
    $postURL = RemoveSpecialChar($postName); 
    
  $updateSQL = "UPDATE blogpost SET postName='$postName', postURL='$postURL', postImg='$pname1', postDes='$postDes', postTitle='$postTitle', postKeywords='$postKeywords', postMetaDes='$postMetaDes' WHERE postID='$postID'";
//echo $updateSQL;
  $Result1 = mysqli_query($conn, $updateSQL);

  $updateGoTo = "allBlogPost.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_qViewValue = "-1";
if (isset($_GET['id'])) {
  $colname_qViewValue = $_GET['id'];
}
$query_qViewValue = "SELECT * FROM blogpost WHERE postID = '$colname_qViewValue'";
$qViewValue = mysqli_query($conn, $query_qViewValue);
$row_qViewValue = mysqli_fetch_assoc($qViewValue);
$totalRows_qViewValue = mysqli_num_rows($qViewValue);
                             
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Edit Blog Post</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
    <!-- full calendar css-->
    <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <!-- easy pie chart-->
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
	<link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
	<link rel="stylesheet" href="css/fullcalendar.css">
	<link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
	<link href="css/xcharts.min.css" rel=" stylesheet">	
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
	<script src="ckeditor/ckeditor.js"></script>

  </head>

  <body>
  <!-- container section start -->
  <section id="container" class="">
     
      
      <?php include("header.php"); ?>     
      <!--header end-->

      <!--sidebar start-->
      <?php include("left-side.php"); ?>
      <!--sidebar end-->
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
              <!--overview start-->
			  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> edit Blog Post</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
						<li><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Blog Post</li>						  	
					</ol>
				</div>
                <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            Edit Blog Post
                        </header>
                          <div class="panel-body">
                          <div class="form">
                               <form action="<?php echo $editFormAction; ?>" method="POST" class="form-validate form-horizontal" role="form" name="editBlogPost" enctype="multipart/form-data" >
                                  
                                  <!--Post Title Name Section -->
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Blog Post URL<span class="required">*</span></label>
                                      <div class="col-lg-10">
                                          <label for="cname">
                                              <?php echo $row_qViewValue['postUrl']; ?>
                                          </label>
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Blog Post Title<span class="required">*</span></label>
                                      <div class="col-lg-10">
                                          <input name="postTitle" type="text" autofocus required class="form-control" value="<?php echo $row_qViewValue['postTitle']; ?>">
                                      </div>
                                  </div>
                                  <!-- Post Title Section End-->
                                  
                                  <!--Post Meta Description Section -->
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Meta Description<span class="required">*</span></label>
                                      <div class="col-lg-10">
                                          <input name="postMetaDes" type="text" autofocus required class="form-control" value="<?php echo $row_qViewValue['postMetaDes']; ?>">
                                      </div>
                                  </div>
                                  <!-- Section End-->
                                  
                                  <!--Post Keywords Section -->
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Post Keywords<span class="required">*</span></label>
                                      <div class="col-lg-10">
                                          <input name="postKeywords" type="text" autofocus required class="form-control" value="<?php echo $row_qViewValue['postKeywords']; ?>">
                                      </div>
                                  </div>
                                  <!-- Section End-->
                                  
                                  
                                  <!--Post Name Section -->
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Post Name<span class="required">*</span></label>
                                      <div class="col-lg-10">
                                          <input name="postName" type="text" autofocus required class="form-control" value="<?php echo $row_qViewValue['postName']; ?>">
                                      </div>
                                  </div>
                                  <!-- Section End-->
                                  
                                        
                                  <!-- Package Image Details Section -->
                                  
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Post Image<span class="required">*</span></label>
                                      <div class="col-lg-10">
								<?php
								  if($row_qViewValue['postImg'])
								  {
									  ?>
                                      <img src="../blog/<?php echo $row_qViewValue['postImg']; ?>" width="100%" height="200px" style="margin-bottom:10px;">
                                      <?php
								  }
								  ?> 
                                  <input type="hidden" name="picture" value="<?php echo $row_qViewValue['postImg']; ?>">                                       
                                  <input type="file" class="form-control" name="image1">
                                      </div>
                                  </div>
                                  <!-- Image Section End-->
                                  
                                  <!-- Post Details Section -->
                                  <div class="form-group">
                                      <label for="cname" class="control-label col-lg-2">Post Details<span class="required">*</span></label>
                                      <div class="col-lg-10">
                                          <textarea class="form-control" name="postDes" required><?php echo $row_qViewValue['postDes']; ?></textarea>
                                      </div>
										<script>
											CKEDITOR.replace('postDes');
                                        </script>
                                  </div>
                                  <!-- Section End-->
                                  
                                  <div class="col-lg-offset-2 col-lg-10">
                                      <input type="submit" class="btn btn-primary" value="Update Blog">
                                      <input type="hidden" name="postID" value="<?php echo $row_qViewValue['postID']; ?>">
                                  </div>
                                  <input type="hidden" name="MM_update" value="editBlogPost">
                              </form>

                          </div>
                          </div>
                      </section>
                  
                </div>
			</div>
            
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section start -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
	<script src="js/jquery-ui-1.10.4.min.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->
    <<script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
	<script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js" ></script>
	<script src="assets/chart-master/Chart.js"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
	<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="js/xcharts.min.js"></script>
	<script src="js/jquery.autosize.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/gdp-data.js"></script>	
	<script src="js/morris.min.js"></script>
	<script src="js/sparklines.js"></script>	
	<script src="js/charts.js"></script>
	<script src="js/jquery.slimscroll.min.js"></script>

  </body>
</html>
