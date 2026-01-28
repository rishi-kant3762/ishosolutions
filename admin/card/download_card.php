<?php

	require('wordwrap.php');
	require('../Connections/pdfConn.php'); 	
	
	$searchID = $_GET['search'];
$query_qCompanyName = "SELECT * FROM customer WHERE customerID  = '$searchID'";
$qCompanyName = mysqli_query($con, $query_qCompanyName);
$row_qCompanyName = mysqli_fetch_assoc($qCompanyName);
$totalRows_qCompanyName = mysqli_num_rows($qCompanyName);
$companyName = $row_qCompanyName['companyName'];

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

$query_qInvoiceOrderDetails = "SELECT * FROM allorder WHERE invoiceID > 0 AND customerID = '$searchID' AND creationTime BETWEEN '$startDate' AND '$endDate' ORDER BY orderID  ASC";
$qInvoiceOrderDetails = mysqli_query($con, $query_qInvoiceOrderDetails);
$row_qInvoiceOrderDetails = mysqli_fetch_assoc($qInvoiceOrderDetails);
$totalRows_qInvoiceOrderDetails = mysqli_num_rows($qInvoiceOrderDetails);
	
	
	$companyName = $row_qCompanyName['companyName'];
    $customerName = $row_qCompanyName['customerName'];
	$mobileNumber = $row_qCompanyName['companyMobile'];
	$emailID = $row_qCompanyName['companyEmailID'];
	$address = $row_qCompanyName['companyAddress'];
	$gstin = $row_qCompanyName['gstin'];
	
	$date = $row_qCompanyName['creationDate'];
	$date = date("j F Y", strtotime($date));
	

	$pdf = new FPDF();
	$pdf -> AddPage();

	$pdf -> SetFont("Arial","B", 12);
	$pdf->Image('header.png',0,0,0);
	$pdf -> Cell(0,27, "",0,1,'R');
	
	$pdf -> SetFont("Arial","BU", 24);
	$pdf -> Cell(0,18, "Ledger Account",0,1,'C');

	
	//Company Name
	$pdf -> SetFont("Arial","B", 12);
	$pdf -> Cell(35,7, "Company Name: ",0,0);
    $pdf -> SetFont("Arial","B", 12);
	$pdf -> Cell(100,7, "{$companyName}",0,1);
	
	//Customer Name
	$pdf -> SetFont("Arial","B", 12);
	$pdf -> Cell(35,7, "Customer Name: ",0,0);
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(100,7, "{$customerName}",0,1);
	
	$pdf -> SetFont("Arial","B", 12);
	$pdf -> Cell(35,7, "Mobile Number: ",0,0);
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(75,7, "+91-{$mobileNumber}",0,1);
	
	$pdf -> SetFont("Arial","B", 12);
	$pdf -> Cell(25,7, "Email ID:",0,0);
	$pdf -> SetFont("Arial","", 12);
	$pdf -> Cell(100,7, "{$emailID}",0,1);
	
	
	if($gstin != "")
	{
		//Customer GST Number
		$pdf -> SetFont("Arial","B", 12);
		$pdf -> Cell(18,7, "GSTIN: ",0,0);
		$pdf -> SetFont("Arial","", 12);
		$pdf -> Cell(0,7, "{$gstin}",0,1);
	}

	//Address Details
	$pdf -> SetFont("Arial","B", 12);
	$pdf -> Cell(20,7, "Address: ",0,0);
    $pdf -> SetFont("Arial","", 12);
	$pdf -> MultiCell(180,7, "{$address}",0,1);

	//Line Break
	$pdf -> Ln();
	
	//Product Heading Details
	$pdf -> SetFont("Arial","B", 12);
	$pdf -> SetFillColor(9,37,74);
	$pdf -> SetTextColor(255);
	$pdf -> Cell(35,10, "Date",0,0,'C', true);
	$pdf -> Cell(80,10, "Transaction",0,0,'L', true);
	$pdf -> Cell(25,10, "Amount",0,0,'L', true);
	$pdf -> Cell(25,10, "Payment",0,0,'L', true);
	$pdf -> Cell(25,10, "Balance",0,1,'L', true);
	$i = 0;
	
	$finalAmount = 0;
    $totalInvoiceAmt = 0;
    $totalRecPaymentAmt = 0;
	
                         
                        do { 
                         $i = $i + 1; 
                         $secondPrintDate =  date("j F Y", strtotime($row_qInvoiceOrderDetails['creationTime']));
                         $updatedDate = $row_qInvoiceOrderDetails['creationTime'];
                         
                         $totalPrice = $row_qInvoiceOrderDetails['totalPrice'];
                         $invoiceRank = $row_qInvoiceOrderDetails['invoiceRank'];
                         $time = $row_qInvoiceOrderDetails['creationTime'];
                         
                         $rankEntry = $invoiceRank . ' on ' . $time;
                        if($i != 1)  
                        {
                        $query_qBankTransaction = "SELECT * FROM banktransaction WHERE customerID = $searchID AND transferDate BETWEEN '$startDate' AND '$updatedDate' ORDER BY banktransactionID ASC";
                        $qBankTransaction = mysqli_query($con, $query_qBankTransaction);
                        $row_qBankTransaction = mysqli_fetch_assoc($qBankTransaction);
                        $totalRows_qBankTransaction = mysqli_num_rows($qBankTransaction);
                        
                        $printDate = date("j F Y", strtotime($row_qBankTransaction['transferDate']));
                         $description = $row_qBankTransaction['description'];
                         $credit = $row_qBankTransaction['transferCredit'];
                        
                                if($totalRows_qBankTransaction> 0)
                                {
                                 do { 
                                 
                                     $finalAmount = $finalAmount - $row_qBankTransaction['transferCredit'];
                                     $totalRecPaymentAmt = $totalRecPaymentAmt + $row_qBankTransaction['transferCredit'];
                                     
                                	$pdf -> SetFont("Arial","", 9);
                                	$pdf -> SetFillColor(255);
                                	$pdf -> SetTextColor(0);
                                	$pdf -> Cell(35,8, "{$printDate}",0,0,'C', true);
                                	$pdf -> Cell(80,8, "{$description}",0,0,'L', true);
                                	$pdf -> Cell(25,8, " ",0,0,'L', true);
                                	$pdf -> Cell(25,8, "INR {$credit}",0,0,'L', true);
                                	$pdf -> Cell(25,8, "INR {$finalAmount}",0,1,'L', true);
    	
                                 } while ($row_qBankTransaction = mysqli_fetch_assoc($qBankTransaction)); 
                                }
                         
                        }
                        
                        $finalAmount = $finalAmount + $row_qInvoiceOrderDetails['totalPrice'];
                        $totalInvoiceAmt = $totalInvoiceAmt + $row_qInvoiceOrderDetails['totalPrice'];
                        
                        $pdf -> SetFont("Arial","", 9);
                    	$pdf -> SetFillColor(255);
                    	$pdf -> SetTextColor(0);
                        $pdf -> Cell(35,8, "{$secondPrintDate}",0,0,'C', true);
                    	$pdf -> Cell(80,8, "{$rankEntry}",0,0,'L', true);
                    	$pdf -> Cell(25,8, "INR {$totalPrice} ",0,0,'L', true);
                    	$pdf -> Cell(25,8, "",0,0,'L', true);
                    	$pdf -> Cell(25,8, "INR {$finalAmount}",0,1,'L', true);
                        
                        $startDate = $updatedDate;
                         }while ($row_qInvoiceOrderDetails = mysqli_fetch_assoc($qInvoiceOrderDetails));
                         
                         
	
	$pdf -> Cell(0,2, "-------------------------------------------------------------------------------------------------------------------------------------------------------------------",0,1,'L');

	
	
	
	$pdf->output(); 
?>