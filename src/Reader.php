<?php
namespace Chokri\PDF;

/**
 * Reader class for reading PDF files into raw data.
 */
class Reader
{
    /**
     * Read a PDF file and return its raw contents as a string.
     *
     * @param string $filePath Path to the PDF file.
     * @return string Raw PDF data.
     * @throws \RuntimeException If the file cannot be read.
     */
    public function readRaw(string $filePath): string
    {
        if (!is_readable($filePath)) {
            throw new \RuntimeException("Cannot read PDF file: $filePath");
        }
        $data = file_get_contents($filePath);
        if ($data === false) {
            throw new \RuntimeException("Failed to read PDF file: $filePath");
        }
        return $data;
    }
}
