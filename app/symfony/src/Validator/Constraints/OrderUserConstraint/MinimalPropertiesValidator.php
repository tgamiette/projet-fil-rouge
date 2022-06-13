<?php

namespace App\Validator\Constraints\OrderUserConstraint;

use App\Repository\ProductsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MinimalPropertiesValidator extends ConstraintValidator {

    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function validate(mixed $value, Constraint $constraint) {

        foreach ($value as $productId => $qty) {
            if (gettype($productId) != 'integer' ){
                $this->context->buildViolation("produit incorrect (id requit) $productId")->addViolation();
            }
            if (gettype($productId) != 'integer' || $qty <= 0  ) {
                $this->context->buildViolation("quantité incorrect pour produit $productId")->addViolation();
            }

            $product = $this->productsRepository->find($productId);
            if (!$product){
                $this->context->buildViolation("Le produit $productId n'existe pas ")->addViolation();
            }
        }
    }
}
