<?php

namespace App\SharedKernel\Presentation\Http;

use App\SharedKernel\Presentation\Http\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    public function __construct(private ValidatorInterface $symfonyValidator){}

    public function validate(object $object, string $constraintCollectionClass): void
    {
        if (!is_subclass_of($constraintCollectionClass, ConstraintCollectionInterface::class)) {
            throw new \Exception();
        }

        # TODO: Risky, maybe hydrator?
        $data = (array) $object;

        $violations = $this->symfonyValidator->validate(
            $data,
            $constraintCollectionClass::rules()
        );

        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }
}
