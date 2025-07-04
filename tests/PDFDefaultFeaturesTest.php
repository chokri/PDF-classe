<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chokri\PDF\PdfNoImageHeader;
require_once __DIR__ . '/../src/PDFNoImageHeader.php';

class PDFDefaultFeaturesTest extends TestCase
{
    public function testDefaultHeaderFooter(): void
    {
        $pdf = new PdfNoImageHeader();
        $pdf->AddPage();
        // Output to string to check PDF is generated
        $output = $pdf->Output('S');
        $this->assertNotEmpty($output, 'PDF output should not be empty');
    }

    public function testWriteHTML(): void
    {
        $pdf = new PdfNoImageHeader();
        $pdf->AddPage();
        $pdf->WriteHTML('<b>Bold</b> <i>Italic</i> <u>Underline</u> <a href="https://example.com">Link</a>');
        $output = $pdf->Output('S');
        $this->assertNotEmpty($output, 'PDF output should not be empty after WriteHTML');
    }

    public function testPageNumbering(): void
    {
        $pdf = new PdfNoImageHeader();
        $pdf->addPageNumbering();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Page 1', 0, 1);
        $pdf->AddPage();
        $pdf->Cell(0, 10, 'Page 2', 0, 1);
        $output = $pdf->Output('S');
        $this->assertNotEmpty($output, 'PDF output should not be empty with page numbering');
    }
}
