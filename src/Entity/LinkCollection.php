<?php

namespace App\Entity;

use App\Repository\LinkCollectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\DTO\ApiPlatform\LinkCollection\LinkCollectionCreateDto;
use App\DTO\ApiPlatform\LinkCollection\LinkCollectionDto as LinkCollectionUpdateDto;
use App\Interfaces\Entity\HasUserInterface;
use App\State\Processor\LinkCollection\LinkCollectionProcessor;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    routePrefix: '/v1',
    normalizationContext: ['groups' => ['link-collection:read']],
    denormalizationContext: ['groups' => ['link-collection:write']],
    operations: [
        new Get(
            security: "is_granted('IS_OWNER', object)",
        ),
        new GetCollection(),
        new Post(
            input: LinkCollectionCreateDto::class,
            processor: LinkCollectionProcessor::class
        ),
        new Patch(
            input: LinkCollectionUpdateDto::class,
            processor: LinkCollectionProcessor::class,
            security: "is_granted('IS_OWNER', object)",
        ),
        new Delete(
            security: "is_granted('IS_OWNER', object)",
        )
    ]
)]
#[ORM\Entity(repositoryClass: LinkCollectionRepository::class)]
#[ORM\Table(name: '`link_collections`')]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class LinkCollection implements HasUserInterface
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['link-collection:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['link-collection:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['link-collection:read'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'linkCollections')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 7, nullable: true)]
    #[Groups(['link-collection:read'])]
    private ?string $color_badge = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['name'], updatable: false)]
    #[Groups(['link-collection:read'])]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getColorBadge(): ?string
    {
        return $this->color_badge;
    }

    public function setColorBadge(?string $color_badge): static
    {
        $this->color_badge = $color_badge;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
