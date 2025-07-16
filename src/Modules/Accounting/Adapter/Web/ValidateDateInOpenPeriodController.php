<?php
namespace Xerpia\Modules\Accounting\Adapter\Web;

use Xerpia\Modules\Accounting\Application\UseCase\ValidateDateInOpenPeriod;

class ValidateDateInOpenPeriodController
{
    private $validateDateInOpenPeriod;

    public function __construct(ValidateDateInOpenPeriod $validateDateInOpenPeriod)
    {
        $this->validateDateInOpenPeriod = $validateDateInOpenPeriod;
    }

    public function validate($date)
    {
        if (empty($date)) {
            return [
                'status' => 400,
                'body' => ['error' => 'Fecha requerida']
            ];
        }
        $isValid = $this->validateDateInOpenPeriod->execute($date);
        return [
            'status' => 200,
            'body' => ['valid' => $isValid]
        ];
    }
}
