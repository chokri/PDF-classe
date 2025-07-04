<?php
namespace Chokri\PDF;

// Ensure FPDF is loaded for all consumers
if (!class_exists('FPDF')) {
    if (file_exists(__DIR__ . '/../../vendor/setasign/fpdf/fpdf.php')) {
        require_once __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php';
    }
}

/**
 * PDF class created by Chokri Khalifa, http://chokrikhalifa.com
 */
class Pdf extends \FPDF
{
    protected $B;
    protected $I;
    protected $U;
    protected $HREF;

    /**
     * PDF constructor.
     * @param string $orientation
     * @param string $unit
     * @param string|array $size
     */
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
        $this->HREF = '';
    }

    /**
     * Header of the PDF document. Override to customize.
     * @return void
     */
    public function Header()
    {
        // Logo to insert
        $this->Image('image.jpg', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Titre du document', 0, 0, 'C');
        $this->Ln(20);
    }

    /**
     * Footer of the PDF document. Override to customize.
     * @return void
     */
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    /**
     * Write HTML content to the PDF.
     * @param string $html
     * @return void
     */
    public function WriteHTML($html)
    {
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else {
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = [];
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    /**
     * Handle opening HTML tags for WriteHTML.
     * @param string $tag
     * @param array $attr
     * @return void
     */
    protected function OpenTag($tag, $attr)
    {
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'] ?? '';
        if ($tag == 'BR')
            $this->Ln(5);
    }

    /**
     * Handle closing HTML tags for WriteHTML.
     * @param string $tag
     * @return void
     */
    protected function CloseTag($tag)
    {
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    /**
     * Set the style for HTML tags in WriteHTML.
     * @param string $tag
     * @param bool $enable
     * @return void
     */
    protected function SetStyle($tag, $enable)
    {
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (['B', 'I', 'U'] as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    /**
     * Insert a hyperlink in the PDF.
     * @param string $URL
     * @param string $txt
     * @return void
     */
    protected function PutLink($URL, $txt)
    {
        $this->SetTextColor(0, 0, 100);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }

    /**
     * Add a title page to the PDF.
     * @param string $title
     * @param string $subtitle
     * @param string $author
     * @return void
     */
    public function addTitlePage(string $title, string $subtitle = '', string $author = ''): void
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 24);
        $this->Cell(0, 40, $title, 0, 1, 'C');
        if ($subtitle) {
            $this->SetFont('Arial', '', 16);
            $this->Cell(0, 20, $subtitle, 0, 1, 'C');
        }
        if ($author) {
            $this->SetFont('Arial', 'I', 12);
            $this->Cell(0, 10, 'By ' . $author, 0, 1, 'C');
        }
        $this->Ln(20);
    }

    /**
     * Add a simple table to the PDF.
     * @param array $header Array of column headers
     * @param array $data Array of row arrays
     * @return void
     */
    public function addTable(array $header, array $data): void
    {
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(40, 6, $col, 1);
            }
            $this->Ln();
        }
    }

    /**
     * Add a centered image to the PDF.
     * @param string $file
     * @param float $w
     * @param float $h
     * @return void
     */
    public function addImageCentered(string $file, float $w = 0, float $h = 0): void
    {
        $this->AddPage();
        $pageWidth = $this->GetPageWidth();
        $imgWidth = $w ?: 100;
        $x = ($pageWidth - $imgWidth) / 2;
        $this->Image($file, $x, null, $imgWidth, $h);
    }

    /**
     * Add page numbering in the footer (call after all pages are added).
     * @return void
     */
    public function addPageNumbering(): void
    {
        $this->AliasNbPages();
    }
}
