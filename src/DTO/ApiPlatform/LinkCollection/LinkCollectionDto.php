<?php
namespace App\DTO\ApiPlatform\LinkCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\Groups;

class LinkCollectionDto
{
    #[Assert\NotBlank(message: "Name field is required")]
    #[Groups(['link-collection:write'])]
    public ?string $name = null;
    
    #[SerializedName('color_badge')]
    #[Assert\CssColor(
        formats: [Assert\CssColor::HEX_LONG],
        message: 'Color must have HEX format(example: #FFFFFF)'
    )]
    #[Groups(['link-collection:write'])]
    public ?string $colorBadge = null;

    #[Assert\Length(min: 3)]
    #[Groups(['link-collection:write'])]
    public ?string $description = null;
}