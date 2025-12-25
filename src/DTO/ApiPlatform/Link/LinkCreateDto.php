<?php

declare(strict_types=1);

namespace App\DTO\ApiPlatform\Link;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class LinkCreateDto extends LinkDto
{
    #[Assert\NotBlank(message: 'Url field is required')]
    #[Assert\Url]
    #[Groups(['link:write'])]
    public ?string $url = null;
}
