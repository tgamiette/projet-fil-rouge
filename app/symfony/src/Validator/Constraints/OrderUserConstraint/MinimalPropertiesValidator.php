<?php

namespace App\Validator\Constraints\OrderUserConstraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[\Attribute]
class MinimalPropertiesValidator extends ConstraintValidator {

    public function validate(mixed $value, Constraint $constraint) {
        foreach ((array)$value as $index => $product) {
            if ($dif = implode(" ", array_diff(['productID', 'quantity'], array_keys($product)))) {
                $this->context->buildViolation("il manque les paramètres $dif dans la ligne $index")->addViolation();
            }
        }
    }
}
