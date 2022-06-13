<?php

namespace App\Serializer;

use App\Entity\MediaObject;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class UploadedFileDenormalizer implements DenormalizerInterface {


    public function __construct(private StorageInterface $storage) {
    }


    public function denormalize(mixed $data, string $type, string $format = null, array $context = []) {
        return $data;

        // TODO: Implement denormalize() method.
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool {
        return $data instanceof UploadedFile;

        // TODO: Implement supportsDenormalization() method.
    }
}
