<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\PeriodRepositoryInterface;

class CreatePeriodController
{
    private $periodRepository;

    public function __construct(PeriodRepositoryInterface $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    public function create($data)
    {
        // Validar datos requeridos
        if (empty($data['name']) || empty($data['date_from']) || empty($data['date_to'])) {
            return [
                'status' => 400,
                'body' => ['error' => 'Faltan datos requeridos (name, date_from, date_to)']
            ];
        }
        // Validar formato de fechas
        $dateFrom = date_create($data['date_from']);
        $dateTo = date_create($data['date_to']);
        if (!$dateFrom || !$dateTo || $dateFrom > $dateTo) {
            return [
                'status' => 400,
                'body' => ['error' => 'Fechas inválidas']
            ];
        }
        // Crear periodo
        $period = $this->periodRepository->createPeriod(
            $data['name'],
            $data['date_from'],
            $data['date_to']
        );
        return [
            'status' => 201,
            'body' => $period
        ];
    }
}
