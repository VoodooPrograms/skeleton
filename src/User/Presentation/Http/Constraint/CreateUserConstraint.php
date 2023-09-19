<?php

namespace App\User\Presentation\Http\Constraint;

use App\SharedKernel\Presentation\Http\ConstraintCollectionInterface;
use App\User\Presentation\Http\Constraint\Ruleset\PasswordRuleset;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserConstraint implements ConstraintCollectionInterface
{
    public static function rules(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => [
                new Assert\Required(),
                new Assert\Type('string'),
                new Assert\Length(min: 3, max: 60),
            ],
            'email' => [
                new Assert\Required(),
                new Assert\Type('string'),
                new Assert\Email(),
                new Assert\Length(min: 3, max: 60),
            ],
            'password' => [
                new PasswordRuleset(),
            ],
            'biography' => [
                new Assert\Optional(),
                new Assert\Type('string'),
            ],
        ], null, null, false);
    }
}
