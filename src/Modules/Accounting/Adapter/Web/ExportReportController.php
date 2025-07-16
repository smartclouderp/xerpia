<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\TransactionRepositoryInterface;

class ExportReportController
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Exporta el libro diario en el formato solicitado
     * @param string $format csv|xlsx|pdf
     * @param string|null $date_from
     * @param string|null $date_to
     * @return array|
     */
    public function export($format, $date_from = null, $date_to = null)
    {
        $transactions = $this->transactionRepository->findAllByDateRange($date_from, $date_to);
        switch (strtolower($format)) {
            case 'csv':
                $filename = 'journal_report.csv';
                $fp = fopen('php://temp', 'w+');
                fputcsv($fp, ['ID', 'Monto', 'Descripción', 'Fecha', 'Cuenta', 'Tercero']);
                foreach ($transactions as $tx) {
                    fputcsv($fp, [$tx['id'], $tx['amount'], $tx['description'], $tx['date'], $tx['account_id'], $tx['third_party_id']]);
                }
                rewind($fp);
                $csv = stream_get_contents($fp);
                fclose($fp);
                return [
                    'status' => 200,
                    'headers' => [
                        'Content-Type' => 'text/csv',
                        'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                    ],
                    'body' => $csv
                ];
            case 'xlsx':
                // Requiere PhpSpreadsheet
                // ...implementación de ejemplo...
                return [
                    'status' => 501,
                    'body' => 'Exportación a Excel no implementada en este ejemplo.'
                ];
            case 'pdf':
                // Requiere TCPDF/FPDF
                // ...implementación de ejemplo...
                return [
                    'status' => 501,
                    'body' => 'Exportación a PDF no implementada en este ejemplo.'
                ];
            default:
                return [
                    'status' => 400,
                    'body' => 'Formato no soportado.'
                ];
        }
    }
}
