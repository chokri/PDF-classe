<?php
require __DIR__ . '/vendor/autoload.php';

use Chokri\PdfClasse\PDF;

// Example usage:
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->WriteHTML('<b>Hello</b> <i>World</i>!');
$pdf->Output('I', 'example.pdf');
?>
