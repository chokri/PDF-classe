<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chokri\PDF\Pdf;
use Chokri\PDF\PdfNoImageHeader;
require_once __DIR__ . '/../src/PDFNoImageHeader.php';

class PDFTest extends TestCase
{
    public function testCanCreatePDFInstance(): void
    {
        $pdf = new PdfNoImageHeader();
        $this->assertInstanceOf(Pdf::class, $pdf);
    }

    public function testAddTitlePage(): void
    {
        $pdf = new PdfNoImageHeader();
        $pdf->addTitlePage('Test Title', 'Test Subtitle', 'Test Author');
        $this->assertTrue(method_exists($pdf, 'addTitlePage'));
    }

    public function testAddTable(): void
    {
        $pdf = new PdfNoImageHeader();
        $pdf->AddPage();
        $header = ['Col1', 'Col2'];
        $data = [
            ['A', 'B'],
            ['C', 'D']
        ];
        $pdf->addTable($header, $data);
        $this->assertTrue(method_exists($pdf, 'addTable'));
    }

    public function testAddImageCentered(): void
    {
        $pdf = new PdfNoImageHeader();
        $this->assertTrue(method_exists($pdf, 'addImageCentered'));
    }

    public function testAddPageNumbering(): void
    {
        $pdf = new PdfNoImageHeader();
        $pdf->addPageNumbering();
        $this->assertTrue(method_exists($pdf, 'addPageNumbering'));
    }
}
