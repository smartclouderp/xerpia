<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\DeleteJournalEntry;

class DeleteJournalEntryController
{
    private DeleteJournalEntry $deleteJournalEntry;

    public function __construct(DeleteJournalEntry $deleteJournalEntry)
    {
        $this->deleteJournalEntry = $deleteJournalEntry;
    }

    public function delete(int $id): array
    {
        $ok = $this->deleteJournalEntry->execute($id);
        if ($ok) {
            return [
                'status' => 200,
                'body' => ['message' => 'Comprobante eliminado']
            ];
        }
        return [
            'status' => 404,
            'body' => ['error' => 'Comprobante no encontrado']
        ];
    }
}
