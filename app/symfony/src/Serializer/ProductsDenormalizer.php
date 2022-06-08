<?php

namespace App\Serializer;

use App\Encoder\MultipartDecoder;
use App\Entity\MediaObject;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;


final class ProductsDenormalizer implements ContextAwareDenormalizerInterface {

    private const ALREADY_CALLED = 'PRODUCT_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(private RequestStack $requestStack) {
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool {
        return $type === Product::class && $format === MultipartDecoder::FORMAT;
        // TODO: Implement supportsDenormalization() method.
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Product {

        $product = new Product($data);
        $product->file = $this->requestStack->getMainRequest()->files->get('file');

        return $product;
        // TODO: Implement denormalize() method.
    }
}
