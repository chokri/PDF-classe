<?php
require __DIR__ . '/vendor/autoload.php';

use Chokri\PDF\Pdf;

// Example usage:
$pdf = new Pdf();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('<b>Hello</b> <i>World</i>!');
$pdf->Output('I', 'example.pdf');
?>
