<?php require_once('Connections/conn.php'); ?>
<?php
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
$query_Recordset1 = "SELECT * FROM login WHERE emailID LIKE '$colname_Recordset1'";
$Recordset1 = mysqli_query($conn, $query_Recordset1);
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$_SESSION['loginAccessID'] = $row_Recordset1['loginID'];
$accessCode = $row_Recordset1['accessValue'];


?>

<header class="header dark-bg">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
    </div>
    <!--logo start-->
    <a href="index.php" class="logo">ISHO <span>Solutions</span></a>
    <!--logo end-->
    <div class="top-nav notification-row">                
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="profile-ava">
                        <img alt="" src="img/user.png">
                    </span>
                    <span class="username" style="color:#fff;"><?php echo $row_Recordset1['name']; ?></span>
               	</a>
                
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
    </div>
  </header>