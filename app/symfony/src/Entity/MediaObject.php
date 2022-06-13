<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @Vich\Uploadable
 */
#[ORM\Entity]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [

            'controller' => CreateMediaObjectAction::class,
            'deserialize' => false,
            'input_formats' => [
                'multipart' => ['multipart/form-data']
            ],
            'validation_groups' => ['Default', 'media_object_create'],
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' =>
                            [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'file' => [
                                            'type' => 'string',
                                            'format' => 'binary',
                                        ],
                                        'product' => [
                                            'type' => 'uri'
                                        ]

                                    ],
                                ],
                            ],
                    ],
                ],
            ],
        ],
    ],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['media_object:read']]
)]
class MediaObject {
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    #[Groups(['media_object:read', 'products_read'])]
    public ?string $contentUrl = null;

    /**
     * @Vich\UploadableField(mapping="products_object", fileNameProperty="filePath")
     */
    #[Assert\NotNull(message: "Image manquante", groups: ['media_object_create'])]
    #[Assert\File(mimeTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'], mimeTypesMessage: "Type de fichier incorect")]
    public ?File $file = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    #[Assert\NotNull(message: 'Produit manquant', groups: ['media_object_create'])]
    #[Assert\Type(Product::class)]
    #[Groups(['media_object:read'])]
    public ?Product $product;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getProduct(): ?Product {
        return $this->product;
    }

    public function setProduct(?Product $product): self {
        $this->product = $product;

        return $this;
    }
}
