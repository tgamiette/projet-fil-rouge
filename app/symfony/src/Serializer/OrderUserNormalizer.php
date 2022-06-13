<?php

namespace App\Serializer;

use App\Entity\MediaObject;
use App\Entity\OrderUser;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class OrderUserNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface {
    use NormalizerAwareTrait;

    public function __construct(private PurchaseRepository $purchaseRepository) {
    }

    private const ALREADY_CALLED = 'ORDER_USER_NORMALIZER_ALREADY_CALLED';

    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null {
        $context[self::ALREADY_CALLED] = true;
        $purchase = $this->purchaseRepository->findOneBy(['orderUser' => $object->getId()]);

        return $this->normalizer->normalize([['token' => $purchase->getStripeToken()]], $format, $context);
//return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof OrderUser;
    }
}
