<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Remark.
 *
 * @ORM\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"remark_read"}},
 *     "denormalization_context"={"groups"={"remark_write"}}
 * })
 */
class Remark
{
    const neutral_point_of_view = 0;
    const for_point_of_view = 1;
    const against_point_of_view = 2;

    /**
     * @var int the id of this Remark
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"remark_read", "decision_read", "general_assembly_read", "collaborater_read"})
     */
    private $id;

    /**
     * @var null|Collaborater[]
     *
     * @Groups({"remark_read", "remark_write"})
     */
    private $approvings;

    /**
     * @var null|Collaborater[]
     *
     * @Groups({"remark_read", "remark_write"})
     */
    private $detractors;

    /**
     * @var null|Collaborater[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Collaborater", mappedBy="remark")
     * @Groups({"remark_read", "remark_write"})
     */
    private $collaboraters;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 2,
     *      invalidMessage = "The point of view message is an integer according to the folling meanings:
     *       0 mean neutral point of view regarding related decision,
     *       1 mean for this decision,
     *       2 mean against"
     * )
     * @Groups({"remark_read", "remark_write"})
     */
    private $PointOfView = self::neutral_point_of_view;

    /**
     * @var \DateTime The created date of this Remark
     *
     * @Assert\Type("datetime")
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="date_add")
     * @Groups({"remark_read"})
     */
    private $createdAt;

    /**
     * @var \DateTime The updated date of this Remark
     *
     * @Assert\Type("datetime")
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="date_upd")
     * @Groups({"remark_read"})
     */
    private $updatedAt;

    /**
     * @var Decision
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\Decision", inversedBy="remarks")
     * @ORM\JoinColumn(name="decision_id", referencedColumnName="id")
     * @Groups({"remark_read", "remark_write"})
     */
    private $decision;

    public function __construct()
    {
        $this->approvings = new ArrayCollection();
        $this->detractors = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
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
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
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

    /**
     * @return Decision
     */
    public function getDecision(): Decision
    {
        return $this->decision;
    }

    public function setDecision(Decision $decision): void
    {
        $this->decision = $decision;
    }

    public function getPointOfView(): int
    {
        return $this->PointOfView;
    }

    public function setPointOfView(int $PointOfView): void
    {
        $this->PointOfView = $PointOfView;
    }

    public function getDetractors(): array
    {
        return $this->detractors->getValues() ?? [];
    }

    public function setDetractors(array $detractors): void
    {
        $this->detractors = $detractors;
    }

    public function addDetractor(Collaborater $detractor): void
    {
        if (!$this->detractors->contains($detractor)) {
            $this->detractors->add($detractor);
        }
    }

    public function addDetractors(array $detractors)
    {
        foreach ($detractors as $detractor) {
            $this->addDetractor($detractor);
        }
    }

    public function removeDetractor(Collaborater $detractor): void
    {
        if ($this->detractors->contains($detractor)) {
            $this->detractors->removeElement($detractor);
        }
    }

    public function removeDetractors(array $detractors): void
    {
        foreach ($detractors as $detractor) {
            $this->removeDetractor($detractor);
        }
    }

    public function getApprovings(): array
    {
        return $this->approvings->getValues() ?? [];
    }

    public function setApprovings(array $approvings): void
    {
        $this->approvings = $approvings;
    }

    public function addApproving(Collaborater $approving): void
    {
        if (!$this->approvings->contains($approving)) {
            $this->approvings->add($approving);
        }
    }

    public function addApprovings(array $approvings)
    {
        foreach ($approvings as $approving) {
            $this->addApproving($approving);
        }
    }

    public function removeApproving(Collaborater $approving): void
    {
        if ($this->approvings->contains($approving)) {
            $this->approvings->removeElement($approving);
        }
    }

    public function removeApprovings(array $approvings): void
    {
        foreach ($approvings as $approving) {
            $this->removeApproving($approving);
        }
    }

    public function getCollaboraters(): array
    {
        return $this->collaboraters;
    }

    public function setCollaboraters(): void
    {
        $this->collaboraters = array_merge($this->getApprovings(), $this->getDetractors()) ?? [];
    }
}
