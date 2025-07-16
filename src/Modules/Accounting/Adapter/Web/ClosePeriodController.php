<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Domain\Repository\PeriodRepositoryInterface;

class ClosePeriodController
{
    private $periodRepository;

    public function __construct(PeriodRepositoryInterface $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    public function close($data)
    {
        if (empty($data['id'])) {
            return [
                'status' => 400,
                'body' => ['error' => 'Id de periodo requerido']
            ];
        }
        $result = $this->periodRepository->closePeriod((int)$data['id']);
        if ($result) {
            return [
                'status' => 200,
                'body' => ['message' => 'Periodo cerrado correctamente']
            ];
        } else {
            return [
                'status' => 404,
                'body' => ['error' => 'Periodo no encontrado o ya cerrado']
            ];
        }
    }
}
