<?php

	require('fpdf.php');
	require('../Connections/pdfConn.php'); 	

    $cardID = $_GET['id'];
	$query_qViewCustomerDetails = "SELECT * FROM registration WHERE id = '$cardID'";
    $qViewCustomerDetails = mysqli_query($con, $query_qViewCustomerDetails);
    $row_qViewCustomerDetails = mysqli_fetch_assoc($qViewCustomerDetails);
    $totalRows_qViewCustomerDetails = mysqli_num_rows($qViewCustomerDetails);

    $name = $row_qViewCustomerDetails['name'];
	$picture = $row_qViewCustomerDetails['picture'];
	$dob = $row_qViewCustomerDetails['dob'];
	$aadharCard = $row_qViewCustomerDetails['aadharCard'];
	$bloodGroup = $row_qViewCustomerDetails['bloodGroup'];
	
	$contact = $row_qViewCustomerDetails['contact'];
	$gender = $row_qViewCustomerDetails['gender'];
	
$address = $row_qViewCustomerDetails['address'];
$dateOfReg = $row_qViewCustomerDetails['DateOfReg'];

$aadharCard = "CODE: ISHO" . $aadharCard;
$year = substr($dateOfReg, 0, 4);
$nextYear = $year + 1;
$nextDate = substr($dateOfReg, 4, 6);
$picture = "../customer/" . $picture;
	$pdf = new FPDF();
	$pdf -> AddPage();

	
	$pdf->Image('1.jpg',0,30,210,120);
	
	
	$pdf->Image('2.jpg',0,155,210,120);
	
	$pdf->Image($picture,19,79.5,47,47);
	
	
	$pdf -> SetFont("Arial","B", 18);
	$pdf -> Cell(0,57, "",0,1,'R');
	$pdf -> Cell(60,105, "",0,0);
	$pdf -> Cell(0,9, "{$aadharCard}",0,1, 'L');
		
	$pdf -> SetFont("Arial","B", 14);
	$pdf -> Cell(86,0, "",0,0);
	$pdf -> Cell(0,14, "{$name}",0,1, 'L');
	
	$pdf -> SetFont("Arial","", 14);
	$pdf -> Cell(83,0, "",0,0);
	$pdf -> Cell(0,5, "{$dob}",0,1, 'L');
	
	$pdf -> SetFont("Arial","", 14);
	$pdf -> Cell(86,0, "",0,0);
	$pdf -> Cell(0,15, "{$contact}",0,1, 'L');
	
	$pdf -> SetFont("Arial","", 14);
	$pdf -> Cell(100,0, "",0,0);
	$pdf -> Cell(0,5, "{$bloodGroup}",0,1, 'L');
	
	$pdf -> SetFont("Arial","", 14);
	$pdf -> Cell(102,0, "",0,0);
	$pdf -> Cell(0,14, "{$gender}",0,1, 'L');
	
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(40, 0, "",0,0);
	$pdf -> Cell(10,60, "",0,1,'R');
	$pdf -> MultiCell(200,5, "{$address}",0,1);
	
	//$pdf -> SetFillColor(255);
	//$pdf -> SetTextColor(28, 28, 102);
	
	$pdf -> SetTextColor(28, 28, 102);
	$pdf -> SetFont("Arial","B", 13);
	$pdf -> Cell(0,10, "",0,1,'R');
	$pdf -> Cell(15,00, "",0,0);
	$pdf -> Cell(32,10, "Date of Issue:",0,0, 'L');
	
	$pdf -> SetTextColor(0);
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(0,10, "{$dateOfReg}",0,1, 'L');
	
	$pdf -> SetTextColor(28, 28, 102);
	$pdf -> SetFont("Arial","B", 13);
	$pdf -> Cell(15,0, "",0,0);
	$pdf -> Cell(10,10, "Till:",0,0, 'L');
	
	$pdf -> SetTextColor(0);
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(0,10, "{$nextYear} {$nextDate}",0,1, 'L');
	
	$pdf -> SetTextColor(28, 28, 102);
	$pdf -> SetFont("Arial","B", 13);
	$pdf -> Cell(15,0, "",0,0);
	$pdf -> Cell(0,10, "Emergency Number: ",0,1, 'L');
	
	$pdf -> SetTextColor(0);
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(0,10, "",0,1, 'L');
	
	$pdf->output(); 
?>