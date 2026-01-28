<?php require_once('admin/Connections/conn.php'); ?>
<?php

$query_qAllExecutiveName = "SELECT * FROM employee ORDER BY name ASC";
$qAllExecutiveName = mysqli_query($conn, $query_qAllExecutiveName);
$row_qAllExecutiveName = mysqli_fetch_assoc($qAllExecutiveName);
$totalRows_qAllExecutiveName = mysqli_num_rows($qAllExecutiveName);

if (isset($_POST['name'])) {
    $aadharCard = mysqli_real_escape_string($conn, $_POST['aadharCard']);
    $bloodGroup = mysqli_real_escape_string($conn, $_POST['bloodGroup']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $fathersName = mysqli_real_escape_string($conn, $_POST['fathersName']);
    $husbandName = mysqli_real_escape_string($conn, $_POST['husbandName']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $pin = mysqli_real_escape_string($conn, $_POST['pin']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $ref = mysqli_real_escape_string($conn, $_POST['ref']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $familyCount = mysqli_real_escape_string($conn, $_POST['familyCount']);


    $uploads_dir = "admin/customer";
    /*------------------------------------------------------------*/
    $pname1 = $_FILES["image1"]["name"];
    $tname1 = $_FILES["image1"]["tmp_name"];
    $name1 = pathinfo($_FILES['image1']['name'], PATHINFO_FILENAME);
    $extension1 = pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
    $increment1 = 0;
    $pname1 = $name1 . '.' . $extension1;
    while (is_file($uploads_dir . '/' . $pname1)) {
        $increment1++;
        $pname1 = $name1 . $increment1 . '.' . $extension1;
    }
    move_uploaded_file($tname1, $uploads_dir . '/' . $pname1);


    $insertSQL = "INSERT INTO registration (name, aadharCard, bloodGroup, picture, dob, gender, maritalStatus, education, fathersName, husbandName, address, district, pin, occupation, contact, ref, email, familyCount) 
                VALUES ('$name', '$aadharCard', '$bloodGroup', '$pname1', '$dob', '$gender', '$maritalStatus', '$education', '$fathersName', '$husbandName', '$address', '$district', '$pin', '$occupation', '$contact', '$ref', '$email', '$familyCount')";
    //echo $insertSQL;
    $Result1 = mysqli_query($conn, $insertSQL);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>International Social Health Organization</title>

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
                <h1>ISHO हेल्थ कार्ड</h1>
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
                        Services
                    </li>
                </ul>
            </div>
            <!-- <div class="pull-right">
            <a href="#" class="get-qoute"><i class="fa fa-arrow-circle-right"></i>Become a Volunteer</a>
        </div> -->
        </div>
    </div>


    <Section>
        <div class="container">
            <style>
                body {
                    font-family: Arial, sans-serif;

                    background-color: #f4f4f4;
                }

                form {
                    background: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                label {

                    margin: 10px 0 5px;
                }

                input[type="text"],
                input[type="email"],
                input[type="tel"],
                input[type="number"],
                input[type="date"],
                textarea,
                select {
                    margin-bottom: 15px;
                    width: 100%;
                    padding: 10px;
                    box-sizing: border-box;
                }

                input[type="submit"] {
                    background-color: #28a745;
                    color: white;
                    border: none;
                    padding: 10px;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background-color: #218838;
                }
            </style>

            <form name="registrationForm" action="" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
                <h2 style="text-align: center;">International Social Helps Organization</h2><br>
                <h4 style="text-align: center;"> <u> Registration Form </u></h4>

                <div class="col-lg-12">
                    <label for="name">Name (English, Capital Letters):</label>
                    <input type="text" name="name" placeholder="Enter your name" class="form-control" required title="Please use uppercase letters only">
                </div>
                <div class="col-lg-6">
                    <label for="name">AADHAR Number:</label>
                    <input type="text" name="aadharCard" placeholder="Enter Your AADHAR Number" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="name">Blood Group:</label>
                    <input type="text" name="bloodGroup" placeholder="Blood Group" class="form-control">
                </div>
                <div class="col-lg-12">
                    <label for="photo">Upload Photo:</label>
                    <input type="file" name="image1" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" class="form-control" required>
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
                <div class="col-lg-12">
                    <label for="gender">Gender:</label>
                    <input type="radio" id="male" name="gender" value="male"> Male
                    <input type="radio" id="male" name="gender" value="female"> Female
                </div>

                <div class="col-lg-12">
                    <label for="education">Educational Details:</label>
                    <textarea id="education" name="education" class="form-control" placeholder="Enter your educational details" rows="4" required></textarea>
                </div>
                <div class="col-lg-12">
                    <label for="fathersName">Father's Name:</label>
                    <input type="text" id="fathersName" name="fathersName" class="form-control" placeholder="Enter father's name" required>
                </div>
                <div class="col-lg-12">
                    <label for="husbandName">Husband's Name (if applicable):</label>
                    <input type="text" id="husbandName" name="husbandName" class="form-control" placeholder="Enter husband's name">
                </div>
                <div class="col-lg-12">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" class="form-control" placeholder="Enter your address" rows="4" required></textarea>
                </div>
                <div class="col-lg-12">
                    <label for="district">District:</label>
                    <input type="text" id="district" name="district" class="form-control" placeholder="Enter your district" required>
                </div>
                <div class="col-lg-12">
                    <label for="pin">Postal Code / PIN:</label>
                    <input type="text" id="pin" name="pin" class="form-control" placeholder="Enter your postal code" required>
                </div>
                <div class="col-lg-12">
                    <label for="occupation">Occupation:</label>
                    <input type="text" id="occupation" name="occupation" class="form-control" placeholder="Enter your occupation" required>
                </div>
                <div class="col-lg-12">
                    <label for="familyCount">Number of Family Members:</label>
                    <input type="number" id="familyCount" name="familyCount" class="form-control" placeholder="Enter number of family members" required>
                </div>
                <div class="col-lg-6">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" class="form-control" placeholder="Enter your contact number" required>
                </div>
                <div class="col-lg-6">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                </div>

                <div class="col-lg-12">
                    <label for="maritalStatus">Supporting Executive:</label>
                    <select id="maritalStatus" name="ref" class="form-control" required>
                        <?php do { ?>
                            <option value="<?php echo $row_qAllExecutiveName['employeeID']; ?>"><?php echo $row_qAllExecutiveName['name']; ?></option>
                        <?php } while ($row_qAllExecutiveName = mysqli_fetch_assoc($qAllExecutiveName)); ?>
                    </select>
                </div>
                <p style="color: #000;"><b>Declaration:-</b> I sincerely declare that I will work for the organization free of cost and will follow all the rules of the organization. If the organization is harmed due to me, then the entire responsibility for this will be mine and I will be liable for punishment. The membership fee given selflessly will not be refunded.</p>
                <input type="submit" value="Submit">
            </form>
        </div>
    </Section>







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