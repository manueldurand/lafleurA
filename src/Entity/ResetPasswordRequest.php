<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResetPasswordRequest
 *
 * @ORM\Table(name="reset_password_request", indexes={@ORM\Index(name="IDX_7CE748AA76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class ResetPasswordRequest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
