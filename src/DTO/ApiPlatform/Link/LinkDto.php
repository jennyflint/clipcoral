<?php

declare(strict_types=1);

namespace App\DTO\ApiPlatform\Link;

use App\Entity\LinkCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class LinkDto
{
    #[Assert\Url]
    public ?string $url = null;

    #[Assert\Length(min: 3)]
    #[Groups(['link:write'])]
    public ?string $description = null;

    #[Groups(['link:write'])]
    public ?LinkCollection $linkCollection = null;
}
