<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link as MetadataLink;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\DTO\ApiPlatform\Link\LinkCreateDto;
use App\DTO\ApiPlatform\Link\LinkDto as LinkUpdateDto;
use App\Interfaces\Entity\HasUserInterface;
use App\Repository\LinkRepository;
use App\State\Processor\Link\LinkProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(operations: [
    new Get(
        security: "is_granted('IS_OWNER', object)",
    ),
    new Post(
        uriTemplate: '/link-collection/{linkCollectionId}/link',
        uriVariables: [
            'linkCollectionId' => new MetadataLink(
                toProperty: 'linkCollection',
                fromClass: LinkCollection::class,
            ),
        ],
        input: LinkCreateDto::class,
        read: false,
        processor: LinkProcessor::class,
    ),
    new Patch(
        security: "is_granted('IS_OWNER', object)",
        input: LinkUpdateDto::class,
        processor: LinkProcessor::class,
    ),
    new Delete(
        security: "is_granted('IS_OWNER', object)",
    ),
], routePrefix: '/v1', normalizationContext: ['groups' => ['link:read']], denormalizationContext: ['groups' => ['link:write']])]
#[ORM\Entity(repositoryClass: LinkRepository::class)]
#[ORM\Table(name: '`links`')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class Link implements HasUserInterface
{
    use SoftDeleteableEntity;

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['link:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['link:read', 'link:write'])]
    private string $url;

    #[ORM\ManyToOne(inversedBy: 'links')]
    #[ORM\JoinColumn(name: 'link_collection_id', nullable: false)]
    #[Groups(['link:read', 'link:write'])]
    private LinkCollection $linkCollection;

    #[ORM\ManyToOne(inversedBy: 'links')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private User $user;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['link:read'])]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getLinkCollection(): LinkCollection
    {
        return $this->linkCollection;
    }

    public function setLinkCollection(LinkCollection $linkCollection): static
    {
        $this->linkCollection = $linkCollection;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
