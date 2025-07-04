<?php
namespace Chokri\PDF;

/**
 * PDF class for testing (no image in header)
 */
class PdfNoImageHeader extends Pdf
{
    /**
     * Override Header to avoid image dependency in tests.
     * @return void
     */
    public function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Titre du document', 0, 0, 'C');
        $this->Ln(20);
    }
}
