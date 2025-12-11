<?php
namespace App\DTO\ApiPlatform\LinkCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
final class LinkCollectionCreateDto extends LinkCollectionDto
{
    #[Assert\NotBlank(message: "Name field is required")]
    #[Assert\Length(min: 3)]
    #[Groups(['link-collection:write'])]
    public ?string $name = null;
}