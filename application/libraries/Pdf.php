<?php
use Dompdf\Dompdf;

class Pdf
{
    public function create_pdf($html, $filename = '', $stream = TRUE)
    {
        // Buat objek Dompdf
        $dompdf = new Dompdf();

        // Load HTML
        $dompdf->loadHtml($html);

        // Set ukuran kertas (opsional)
        $dompdf->setPaper('A4', 'portrait');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Output file
        if ($stream) {
            // Jika $stream TRUE, PDF akan langsung ditampilkan di browser
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            // Jika $stream FALSE, file akan di-download
            return $dompdf->output();
        }
    }
}
