<?php

namespace App\Entity;

use App\Enum\Hours;
use App\Enum\Position;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTime $birthdate = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column]
    private ?\DateTime $employed_since = null;

    #[ORM\Column]
    private ?\DateTime $employed_until = null;

    #[ORM\Column(enumType: Hours::class)]
    private ?Hours $hours = null;

    #[ORM\Column]
    private ?int $salary = null;

    #[ORM\Column(enumType: Position::class)]
    private ?Position $position = null;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'employees')]
    private ?Employee $manager = null;


    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Employee::class)]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getEmployedSince(): ?\DateTime
    {
        return $this->employed_since;
    }

    public function setEmployedSince(\DateTime $employed_since): static
    {
        $this->employed_since = $employed_since;

        return $this;
    }

    public function getEmployedUntil(): ?\DateTime
    {
        return $this->employed_until;
    }

    public function setEmployedUntil(\DateTime $employed_until): static
    {
        $this->employed_until = $employed_until;

        return $this;
    }

    public function getHours(): ?Hours
    {
        return $this->hours;
    }

    public function setHours(Hours $hours): static
    {
        $this->hours = $hours;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): static
    {
        $this->position = $position;

        return $this;
    }
}
