<?php require_once('admin/Connections/conn.php'); ?>
<?php
$colname_qSearchHospital = "-1";
if (isset($_POST['search'])) {
    $colname_qSearchHospital = $_POST['search'];
}
$query_qSearchHospital = "SELECT * FROM hospital WHERE address LIKE '%$colname_qSearchHospital%'";
$qSearchHospital = mysqli_query($conn, $query_qSearchHospital);
$row_qSearchHospital = mysqli_fetch_assoc($qSearchHospital);
$totalRows_qSearchHospital = mysqli_num_rows($qSearchHospital);
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Listed Hospital :: International Social Health Organization</title>



    <!-- mobile responsive meta -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">





    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/responsive.css">



    <link rel="apple-touch-icon" sizes="180x180" href="images/fav-icon/apple-touch-icon.png">

    <link rel="icon" type="image/png" href="images/fav-icon/favicon-32x32.png" sizes="32x32">

    <link rel="icon" type="image/png" href="images/fav-icon/favicon-16x16.png" sizes="16x16">







</head>

<body>



    <?php include 'header.php';

    ?>









    <div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/4.jpg);">

        <div class="container">

            <div class="box">

                <h1>Hospital List</h1>

            </div>

        </div>

    </div>

    <div class="breadcumb-wrapper">

        <div class="container">

            <div class="pull-left">

                <ul class="list-inline link-list">

                    <li>

                        <a href="index.php">Home</a>

                    </li>



                    <li>

                        Hospital List

                    </li>

                </ul>

            </div>



        </div>

    </div>





    <section class="about sec-padd2">

        <div class="container">

            <div class="row" style="margin-top: 30px;">

                <div class="col-lg-3">

                    <div class="single-about-box2 text-lg-left text-center">

                        <img src="images/hospital.avif" alt="Hospital">

                    </div>

                </div>

                <div class="col-lg-9">

                    <div class="single-about-box2">

                        <h3>Search Hospital</h3>
                        <br>
                        <div class="row">

                            <div class="col-md-12">
                                <form method="post" name="searchHospital" action="">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="search" placeholder="City Name" autofocus="" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-info form-control" value="Search Hospital" style="background: #fbc101;">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


        </div>

    </section>


    <section class="pt-70 mb-20">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">
                    <?php
                    if (isset($_POST['search'])) {
                        if ($totalRows_qSearchHospital > 0) {
                    ?>

                            <div class="sec-title mb-20">

                                <h2 style="margin-bottom: 20px;">HOSPITAL <span>DETAILS</span></h2>

                            </div>
                            <table class=" table table-stripe dtable-responsive table-bordered" style="text-align: center;">
                                <tbody>
                                    <tr>
                                        <td width="5%"><strong>S.No</strong></td>
                                        <td width="20%"><strong>Hospital Name</strong></td>
                                        <td width="20%"><strong>Contact Person</strong></td>
                                        <td width="15%"><strong>Contact Number</strong></td>
                                        <td width="25%"><strong>Specialized IN</strong></td>
                                        <td width="25%"><strong>Address</strong></td>
                                    </tr>
                                </tbody>
                                <?php
                                $i = 0;
                                do {
                                    $i = $i + 1; ?>
                                    <tr>
                                        <td><strong><?php echo $i; ?>.</strong></td>
                                        <td><?php echo $row_qSearchHospital['hospitalName']; ?></td>
                                        <td><?php echo $row_qSearchHospital['contactPerson']; ?></td>
                                        <td><?php echo $row_qSearchHospital['contactNumber']; ?></td>
                                        <td><?php echo $row_qSearchHospital['specializedIn']; ?></td>
                                        <td><?php echo $row_qSearchHospital['address']; ?></td>
                                    </tr>
                                <?php } while ($row_qSearchHospital = mysqli_fetch_assoc($qSearchHospital)); ?>




                            </table>
                        <?php
                        } else {
                        ?>
                            <h3 style="font-size:18px; color:red;">No Hospital Infomation Available at this location - <?php echo $_POST['search']; ?></h3>
                    <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <div class="border-bottom"></div>

    <section class="call-out">

        <div class="container">

            <div class="float_left">

                <h4>Join Our Mission to Improve a Child's Feature, Life and Our Health.</h4>

            </div>

            <div class="float_right">

                <a href="tel:+917752941777" class="thm-btn style-3">Get Involeved</a>

            </div>



        </div>

    </section>



    <?php include 'footer.php';

    ?>



    <!-- Scroll Top  -->

    <button class="scroll-top tran3s color2_bg"><span class="fa fa-angle-up"></span></button>

    <!-- preloader  -->



    <div id="donate-popup" class="donate-popup">

        <div class="close-donate theme-btn"><span class="fa fa-close"></span></div>

        <div class="popup-inner">





            <div class="container">

                <div class="donate-form-area">

                    <div class="section-title center">

                        <h2>Donation Information</h2>

                    </div>



                    <h4>How much would you like to donate:</h4>



                    <form action="#" class="donate-form default-form">

                        <ul class="chicklet-list clearfix">

                            <li>

                                <input type="radio" id="donate-amount-1" name="donate-amount" />

                                <label for="donate-amount-1" data-amount="1000">$1000</label>

                            </li>

                            <li>

                                <input type="radio" id="donate-amount-2" name="donate-amount" checked="checked" />

                                <label for="donate-amount-2" data-amount="2000">$2000</label>

                            </li>

                            <li>

                                <input type="radio" id="donate-amount-3" name="donate-amount" />

                                <label for="donate-amount-3" data-amount="3000">$3000</label>

                            </li>

                            <li>

                                <input type="radio" id="donate-amount-4" name="donate-amount" />

                                <label for="donate-amount-4" data-amount="4000">$4000</label>

                            </li>

                            <li>

                                <input type="radio" id="donate-amount-5" name="donate-amount" />

                                <label for="donate-amount-5" data-amount="5000">$5000</label>

                            </li>

                            <li class="other-amount">



                                <div class="input-container" data-message="Every dollar you donate helps end hunger.">

                                    <span>Or</span><input type="text" id="other-amount" placeholder="Other Amount" />

                                </div>

                            </li>

                        </ul>



                        <h3>Donor Information</h3>



                        <div class="form-bg">

                            <div class="row clearfix">

                                <div class="col-md-6 col-sm-6 col-xs-12">



                                    <div class="form-group">

                                        <p>Your Name*</p>

                                        <input type="text" name="fname" placeholder="">

                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="form-group">

                                        <p>Email*</p>

                                        <input type="text" name="fname" placeholder="">

                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="form-group">

                                        <p>Address*</p>

                                        <input type="text" name="fname" placeholder="">

                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <div class="form-group">

                                        <p>Phn Num*</p>

                                        <input type="text" name="fname" placeholder="">

                                    </div>

                                </div>



                            </div>

                        </div>



                        <ul class="payment-option">

                            <li>

                                <h4>Choose your payment method:</h4>

                            </li>

                            <li>

                                <div class="checkbox">

                                    <label>

                                        <input name="pay-us" type="checkbox">

                                        <span>Paypal</span>

                                    </label>

                                </div>

                            </li>

                            <li>

                                <div class="checkbox">

                                    <label>

                                        <input name="pay-us" type="checkbox">

                                        <span>Offline Donation</span>

                                    </label>

                                </div>

                            </li>

                            <li>

                                <div class="checkbox">

                                    <label>

                                        <input name="pay-us" type="checkbox">

                                        <span>Credit Card</span>

                                    </label>

                                </div>

                            </li>

                            <li>

                                <div class="checkbox">

                                    <label>

                                        <input name="pay-us" type="checkbox">

                                        <span>Debit Card</span>

                                    </label>

                                </div>

                            </li>

                        </ul>



                        <div class="center"><button class="thm-btn" type="submit">Donate Now</button></div>





                    </form>

                </div>

            </div>







        </div>

    </div>



    <!-- jQuery -->

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/menu.js"></script>

    <script src="js/owl.carousel.min.js"></script>

    <script src="js/jquery.mixitup.min.js"></script>

    <script src="js/jquery.fancybox.pack.js"></script>

    <script src="js/imagezoom.js"></script>

    <script src="js/jquery.magnific-popup.min.js"></script>

    <script src="js/jquery.polyglot.language.switcher.js"></script>

    <script src="js/SmoothScroll.js"></script>

    <script src="js/jquery.appear.js"></script>

    <script src="js/jquery.countTo.js"></script>

    <script src="js/validation.js"></script>

    <script src="js/wow.js"></script>

    <script src="js/jquery.fitvids.js"></script>

    <script src="js/nouislider.js"></script>

    <script src="js/isotope.js"></script>

    <script src="js/pie-chart.js"></script>





    <!-- revolution slider js -->

    <script src="js/rev-slider/jquery.themepunch.tools.min.js"></script>

    <script src="js/rev-slider/jquery.themepunch.revolution.min.js"></script>

    <script src="js/rev-slider/revolution.extension.actions.min.js"></script>

    <script src="js/rev-slider/revolution.extension.carousel.min.js"></script>

    <script src="js/rev-slider/revolution.extension.kenburn.min.js"></script>

    <script src="js/rev-slider/revolution.extension.layeranimation.min.js"></script>

    <script src="js/rev-slider/revolution.extension.migration.min.js"></script>

    <script src="js/rev-slider/revolution.extension.navigation.min.js"></script>

    <script src="js/rev-slider/revolution.extension.parallax.min.js"></script>

    <script src="js/rev-slider/revolution.extension.slideanims.min.js"></script>

    <script src="js/rev-slider/revolution.extension.video.min.js"></script>





    <script src="js/custom.js"></script>



    </div>




</body>

</html>