<?php
    require('../fpdf/fpdf.php');
    include("../admin/dbconnect.php");

    if (isset($_POST['pdf'])) {

    $residentid=$_POST['pdf'];
    $houseid=$_POST['house_id'];
    $room_no=$_POST['room_no'];

    $q1="SELECT resident.id, resident.email, resident.phone_no, resident.house_id, resident.room_no, 
        house_summary.address, house_summary.total_electric_usage_house, house_summary.total_rm,
        room_summary.total_electric_usage, room_summary.total_percentage_usage
        FROM resident 
        INNER JOIN house_summary ON resident.house_id=house_summary.id
        INNER JOIN room_summary ON resident.id=room_summary.resident_id
        WHERE resident.id='$residentid'";

    $pdf = new FPDF('P', 'mm', "A4");
    $pdf -> AddPage();

    //PDF Ttile
    $pdf -> SetFont('Arial', 'B', 20);

    $pdf -> Cell(71, 10, '',0,0);
    $pdf -> Cell(59, 5, 'Invoice',0,0);
    $pdf -> Cell(59, 10, '',0,1);

    //PDF Heading 1
    $pdf -> SetFont('Arial', 'B', 15);

    $pdf -> Cell(71, 5, 'House Details',0,0);
    $pdf -> Cell(59, 5, '',0,0);
    $pdf -> Cell(59, 10, "Resident's Information",0,1);

    //House Information
    $pdf -> SetFont('Arial', '', 10);

    $pdf -> Cell(25, 5, 'House Details:',0,0);
    $pdf -> Cell(105, 5, 'T',0,0);

    //User Information
    $pdf -> Cell(25, 5, 'User ID:',0,0);
    $pdf -> Cell(34, 5, 'Y',0,1);



    $pdf -> Output();
    }

?>