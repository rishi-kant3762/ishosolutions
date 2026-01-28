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
if(isset($_POST['name']))
{
    $bloodGroup = mysqli_real_escape_string($conn,$_POST['bloodGroup']);
    $aadharCard = mysqli_real_escape_string($conn,$_POST['aadharCard']);
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $dob = mysqli_real_escape_string($conn,$_POST['dob']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $maritalStatus = mysqli_real_escape_string($conn,$_POST['maritalStatus']);
    $education = mysqli_real_escape_string($conn,$_POST['education']);
    $fathersName = mysqli_real_escape_string($conn,$_POST['fathersName']);
    $husbandName = mysqli_real_escape_string($conn,$_POST['husbandName']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $district = mysqli_real_escape_string($conn,$_POST['district']);
    $pin = mysqli_real_escape_string($conn,$_POST['pin']);
    $occupation = mysqli_real_escape_string($conn,$_POST['occupation']);
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $ref = mysqli_real_escape_string($conn,$_POST['ref']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $familyCount = mysqli_real_escape_string($conn,$_POST['familyCount']);
    
    
    	$uploads_dir = "customer";
/*------------------------------------------------------------*/
  $pname1 = $_FILES["image1"]["name"]; 
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
   
    
    $insertSQL = "INSERT INTO registration (name, aadharCard, bloodGroup, picture, dob, gender, maritalStatus, education, fathersName, husbandName, address, district, pin, occupation, contact, ref, email, familyCount) 
                VALUES ('$name', '$aadharCard', '$bloodGroup', '$pname1', '$dob', '$gender', '$maritalStatus', '$education', '$fathersName', '$husbandName', '$address', '$district', '$pin', '$occupation', '$contact', '$ref', '$email', '$familyCount')";
    //echo $insertSQL;
  $Result1 = mysqli_query($conn, $insertSQL);
    
  $insertGoTo = "allCustomer.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$query_qAllExecutiveName = "SELECT * FROM employee ORDER BY name ASC";
$qAllExecutiveName = mysqli_query($conn, $query_qAllExecutiveName);
$row_qAllExecutiveName = mysqli_fetch_assoc($qAllExecutiveName);
$totalRows_qAllExecutiveName = mysqli_num_rows($qAllExecutiveName);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>New Customer</title>

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
					<h3 class="page-header"><i class="fa fa-user" aria-hidden="true"></i> New Customer</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
						<li><i class="fa fa-user" aria-hidden="true"></i> New Customer</li>						  	
					</ol>
				</div>
                <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            New Customer
                        </header>
                          <div class="panel-body">
                          <div class="form">
                               <form action="<?php echo $editFormAction; ?>" method="POST" class="form-validate form-horizontal" role="form" name="newEmployee" enctype="multipart/form-data" >
                                  
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <label for="name">Name (English, Capital Letters):</label>
                                            <input type="text" name="name" placeholder="Enter your name" class="form-control" required title="Please use uppercase letters only">
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="photo">Upload Photo:</label>
                                        <input type="file" name="image1"  class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        <label for="dob">Date of Birth:</label>
                                        <input type="date" id="dob" name="dob" class="form-control"  required>
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="maritalStatus">Marital Status:</label>
                                        <select id="maritalStatus" name="maritalStatus" class="form-control" required>
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                            <option value="divorced">Divorced</option>
                                            <option value="widowed">Widowed</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        <label for="gender">Gender:</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="maritalStatus">Supporting Executive:</label>
                                        <select id="maritalStatus" name="ref" class="form-control" required>
                                             <?php do { ?>
                                            <option value="<?php echo $row_qAllExecutiveName['employeeID']; ?>"><?php echo $row_qAllExecutiveName['name']; ?></option>
                                            <?php } while ($row_qAllExecutiveName = mysqli_fetch_assoc($qAllExecutiveName)); ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                        <label for="education">Educational Details:</label>
                                        <textarea id="education" name="education" class="form-control"  placeholder="Enter your educational details" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        <label for="fathersName">Father's Name:</label>
                                        <input type="text" id="fathersName" name="fathersName" class="form-control"  placeholder="Enter father's name" required>
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="husbandName">Husband's Name (if applicable):</label>
                                        <input type="text" id="husbandName" name="husbandName" class="form-control"  placeholder="Enter husband's name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        <label for="fathersName">Aadhar Number:</label>
                                        <input type="text" name="aadharCard" class="form-control"  placeholder="Enter Aadhar Number" required>
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="husbandName">Blood Group:</label>
                                        <input type="text" name="bloodGroup" class="form-control"  placeholder="Enter Blood Group">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                        <label for="address">Address:</label>
                                        <textarea id="address" name="address" class="form-control"  placeholder="Enter your address" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        <label for="district">District:</label>
                                        <input type="text" id="district" name="district" class="form-control"  placeholder="Enter your district" required>
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="pin">Postal Code / PIN:</label>
                                        <input type="text" id="pin" name="pin" class="form-control"  placeholder="Enter your postal code" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                        <label for="occupation">Occupation:</label>
                                        <input type="text" id="occupation" name="occupation" class="form-control"  placeholder="Enter your occupation" required>
                                        </div>
                                        <div class="col-lg-6">
                                        <label for="familyCount">Number of Family Members:</label>
                                        <input type="number" id="familyCount" name="familyCount" class="form-control"  placeholder="Enter number of family members" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <label for="contact">Contact Number:</label>
                                            <input type="tel" id="contact" name="contact" class="form-control"  placeholder="Enter your contact number" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="email">Email:</label>
                                            <input type="email" id="email" name="email" class="form-control"  placeholder="Enter your email address" required>
                                        </div>
                                    </div>
                                    
                
                                  
                                  
                                  <div class="col-lg-offset-2 col-lg-10">
                                      <input type="submit" class="btn btn-primary" value="Add New Customer">
                                  </div>
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
