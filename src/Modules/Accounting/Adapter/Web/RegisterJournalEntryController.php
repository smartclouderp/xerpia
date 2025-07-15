<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\RegisterJournalEntry;
use Xerpia\Modules\Accounting\Domain\Entity\JournalEntryLine;

class RegisterJournalEntryController
{
    private RegisterJournalEntry $registerJournalEntry;

    public function __construct(RegisterJournalEntry $registerJournalEntry)
    {
        $this->registerJournalEntry = $registerJournalEntry;
    }

    public function register(array $data): array
    {
        $required = ['date', 'description', 'third_party_id', 'lines'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return [
                    'status' => 400,
                    'body' => ['error' => "El campo $field es requerido"]
                ];
            }
        }
        $lines = [];
        foreach ($data['lines'] as $line) {
            if (!isset($line['account_id'], $line['debit'], $line['credit'])) {
                return [
                    'status' => 400,
                    'body' => ['error' => 'Cada línea debe tener account_id, debit y credit']
                ];
            }
            $lines[] = new JournalEntryLine(0, 0, $line['account_id'], $line['debit'], $line['credit'], $line['description'] ?? null);
        }
        $ok = $this->registerJournalEntry->execute(
            $data['date'],
            $data['description'],
            $data['third_party_id'],
            $lines
        );
        if ($ok) {
            return [
                'status' => 201,
                'body' => ['message' => 'Comprobante registrado']
            ];
        }
        return [
            'status' => 500,
            'body' => ['error' => 'No se pudo registrar el comprobante']
        ];
    }
}
