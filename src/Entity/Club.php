<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'student_club')]
    private Collection $club_student;

    
    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->club_student = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getClubStudent(): Collection
    {
        return $this->club_student;
    }

    public function addClubStudent(Student $clubStudent): self
    {
        if (!$this->club_student->contains($clubStudent)) {
            $this->club_student->add($clubStudent);
            $clubStudent->addStudentClub($this);
        }

        return $this;
    }

    public function removeClubStudent(Student $clubStudent): self
    {
        if ($this->club_student->removeElement($clubStudent)) {
            $clubStudent->removeStudentClub($this);
        }

        return $this;
    }

    

    
    
}
