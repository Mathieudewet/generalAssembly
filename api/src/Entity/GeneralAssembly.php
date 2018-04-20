<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class GeneralAssembly.
 *
 * @ORM\Entity
 * @UniqueEntity("date")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"general_assembly_read"}},
 *     "denormalization_context"={"groups"={"general_assembly_write"}}
 * })
 */
class GeneralAssembly
{
    /**
     * @var int the id of this GeneralAssembly
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"general_assembly_read", "decision_read"})
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @Assert\Type("datetime")
     * @ORM\Column(type="datetime")
     * @Groups({"general_assembly_read", "general_assembly_write", "decision_read"})
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @Assert\Type("date")
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="date_add")
     * @Groups({"general_assembly_read"})
     */
    private $createdAt;

    /**
     * @var null|\DateTime The updated date of this General Assembly
     *
     * @Assert\Type("datetime")
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="date_upd")
     * @Groups({"general_assembly_read"})
     */
    private $updatedAt;

    /**
     * @var Decision[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Decision", mappedBy="generalAssembly")
     * @Groups({"general_assembly_read", "general_assembly_write"})
     */
    private $decisions;

    public function __construct()
    {
        $this->decisions = new ArrayCollection();
    }

    /**
     * @return null|\DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Decision[]|Collection
     */
    public function getDecisions()
    {
        return $this->decisions;
    }

    /**
     * @param Decision[]|Collection $decisions
     */
    public function setDecisions(array $decisions): void
    {
        $this->decisions = $decisions;
    }

    public function addDecision(Decision $decision): void
    {
        if (!$this->decisions->contains($decision)) {
            $this->decisions->add($decision);
        }
    }

    /**
     * @param Decision[]|Collection $decisions
     */
    public function addDecisions(array $decisions)
    {
        foreach ($decisions as $decision) {
            $this->addDecision($decision);
        }
    }

    public function removeDecision(Decision $decision): void
    {
        if ($this->decisions->contains($decision)) {
            $this->decisions->removeElement($decision);
        }
    }

    /**
     * @param Decision[]|Collection $decisions
     */
    public function removeDecisions(array $decisions): void
    {
        foreach ($decisions as $decision) {
            $this->removeDecision($decision);
        }
    }

    public function getDate(): string
    {
        return $this->date->format('d/m/Y');
    }

    public function getDateTime(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
