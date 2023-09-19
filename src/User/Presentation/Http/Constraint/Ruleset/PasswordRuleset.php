<?php

namespace App\User\Presentation\Http\Constraint\Ruleset;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

class PasswordRuleset extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length(min: 8, max: 24),
            new Assert\NotCompromisedPassword(),
            new Assert\PasswordStrength(['minScore' => Assert\PasswordStrength::STRENGTH_MEDIUM]),
        ];
    }
}
