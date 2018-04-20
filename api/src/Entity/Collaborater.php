<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Remark.
 *
 * @ORM\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"collaborater_read"}},
 *     "denormalization_context"={"groups"={"collaborater_write"}}
 * }, itemOperations={
 *     "get",
 *     "put"={"access_control"="object === user"},
 *     "delete"={"access_control"="object === user"}
 * }, collectionOperations={
 *     "get"={"method"="GET",  "path"="/collaboraters", "normalization_context"={"groups"={"collaborater_read_list"}}},
 *     "post"={"method"="POST", "normalization_context"={"groups"={"collaborater_write"}}},
 *  })
 */
class Collaborater
{
    /**
     * @var int the id of this Collaborater
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"collaborater_read", "decision_read", "general_assembly_read", "remark_read", "collaborater_read_list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotNull
     * @Assert\Type(
     *     type="alpha",
     *     message="{{ value }} must be {{ type }} type."
     * )
     * @Groups({"collaborater_read", "collaborater_read_list", "collaborater_write"})
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotNull
     * @Assert\Type(
     *     type="alpha",
     *     message="{{ value }} must be {{ type }} type."
     * )
     * @Groups({"collaborater_read", "collaborater_read_list", "collaborater_write"})
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotNull
     * @Assert\Regex(
     *     pattern="/[a-zA-Z]{3,}@les-tilleuls\.coop|@la-cooperative-des-tilleuls\.coop$/",
     *     message="invalid email"
     * )
     * @Groups({"collaborater_read", "collaborater_read_list", "collaborater_write"})
     */
    private $email;

    /**
     * @var Remark
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Remark", inversedBy="collaboraters")
     * @ORM\JoinColumn(name="remark_id", referencedColumnName="id")
     * @Groups({"collaborater_read"})
     */
    private $remark;

    public function getPassword()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->getLastname().' '.$this->firstname();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRemark(): Remark
    {
        return $this->remark;
    }

    public function setRemark(Remark $remark): void
    {
        $this->remark = $remark;
    }
}
