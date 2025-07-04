<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chokri\PdfClasse\PDF;
use Chokri\PdfClasse\PDFNoImageHeader;
require_once __DIR__ . '/../src/PDFNoImageHeader.php';

class PDFTest extends TestCase
{
    public function testCanCreatePDFInstance(): void
    {
        $pdf = new PDFNoImageHeader();
        $this->assertInstanceOf(PDF::class, $pdf);
    }

    public function testAddTitlePage(): void
    {
        $pdf = new PDFNoImageHeader();
        $pdf->addTitlePage('Test Title', 'Test Subtitle', 'Test Author');
        $this->assertTrue(method_exists($pdf, 'addTitlePage'));
    }

    public function testAddTable(): void
    {
        $pdf = new PDFNoImageHeader();
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
        $pdf = new PDFNoImageHeader();
        $this->assertTrue(method_exists($pdf, 'addImageCentered'));
    }

    public function testAddPageNumbering(): void
    {
        $pdf = new PDFNoImageHeader();
        $pdf->addPageNumbering();
        $this->assertTrue(method_exists($pdf, 'addPageNumbering'));
    }
}
