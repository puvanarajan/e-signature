<?php

namespace App\Services\Signature;

use setasign\Fpdi\Fpdi;

/**
 * Class SignatureService
 *
 * This service handles the generation of signatures on PDFs.
 */
class SignatureService
{
    /**
     * Generate a signature on the last page of a PDF.
     *
     * @param string $sourceFile The path to the source PDF file.
     * @param string $signature The path to the signature image file.
     * @param string $output The path to the output PDF file.
     * @return void
     */
    public function generateSignature($sourceFile, $signature, $output)
    {
        $pdf = new FPDI();

        // Set the source file
        $pageCount = $pdf->setSourceFile($sourceFile);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $tplId = $pdf->importPage($pageNo);
            $pdf->useTemplate($tplId);
            if ($pageNo == $pageCount) {
                $pdf->Image($signature, 15, 250, 50, 50);
            }
        }

        $pdf->Output($output, 'F');
    }
}
