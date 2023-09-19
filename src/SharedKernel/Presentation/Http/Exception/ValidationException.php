<?php

namespace App\SharedKernel\Presentation\Http\Exception;

use App\SharedKernel\Presentation\Http\Exception\Status\BadRequest;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[BadRequest]
class ValidationException extends \Exception
{

    public function __construct(
        private ConstraintViolationListInterface $violationList
    ) {
        parent::__construct('Validation error');
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
