<?php

namespace App\SharedKernel\Presentation\Http;

use Symfony\Component\Validator\Constraints as Assert;

interface ConstraintCollectionInterface
{
    public static function rules(): Assert\Collection;
}