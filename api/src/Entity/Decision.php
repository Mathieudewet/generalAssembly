<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Decision.
 *
 * @ORM\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"decision_read"}},
 *     "denormalization_context"={"groups"={"decision_write"}}
 * })
 */
class Decision
{
    /**
     * @var int the id of this Decision
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"decision_read", "general_assembly_write"})
     */
    private $id;

    /**
     * @var null|string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"decision_read", "decision_write"})
     */
    private $description;

    /**
     * @var Remark[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Remark", mappedBy="decision")
     * @Groups({"decision_read", "decision_write"})
     */
    private $remarks;

    /**
     * @var \DateTime The created date of this General Assembly
     *
     * @Assert\Type("datetime")
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="date_add")
     * @Groups({"decision_read"})
     */
    private $createdAt;

    /**
     * @var \DateTime The updated date of this General Assembly
     * @Assert\Type("datetime")
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="date_upd")
     */
    private $updatedAt;

    /**
     * @var GeneralAssembly
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="App\Entity\GeneralAssembly", inversedBy="decisions")
     * @ORM\JoinColumn(name="general_assembly_id", referencedColumnName="id")
     * @Groups({"decision_read", "decision_write"})
     */
    private $generalAssembly;

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
     * @return GeneralAssembly
     */
    public function getGeneralAssembly(): GeneralAssembly
    {
        return $this->generalAssembly;
    }

    /**
     * @param  $generalAssembly
     */
    public function setGeneralAssembly($generalAssembly): void
    {
        $this->generalAssembly = $generalAssembly;
    }

    /**
     * @return Remark[]|Collection
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param Remark[]|Collection $remarks
     */
    public function setRemarks(array $remarks): void
    {
        $this->remarks = $remarks;
    }

    public function addRemark(Remark $remark): void
    {
        if (!$this->remarks->contains($remark)) {
            $this->remarks->add($remark);
        }
    }

    /**
     * @param Remark[]|Collection $remarks
     */
    public function addRemarks(array $remarks)
    {
        foreach ($remarks as $remark) {
            $this->addRemark($remark);
        }
    }

    public function removeRemark(Remark $remark): void
    {
        if ($this->remarks->contains($remark)) {
            $this->remarks->removeElement($remark);
        }
    }

    /**
     * @param Remark[]|Collection $remarks
     */
    public function removeRemarks(array $remarks): void
    {
        foreach ($remarks as $remark) {
            $this->removeRemark($remark);
        }
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
