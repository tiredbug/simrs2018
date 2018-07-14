<?php
use \setasign\Fpdi;

require_once('fpdf/fpdf.php');
require_once('fpdi2/src/autoload.php');

// initiate FPDI
$pdf = new Fpdi\Fpdi();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile("SEPpdf");
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useImportedPage($tplIdx, 10, 10, 100);

// now write some text above the imported page
$pdf->SetFont('Helvetica');
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(30, 30);
$pdf->Write(0, 'This is just a simple text');

$pdf->Output(); 

?>