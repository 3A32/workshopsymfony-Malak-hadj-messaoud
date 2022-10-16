<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $NSC = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Classroom $classroom = null;



    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: Club::class, inversedBy: 'club_student')]
    private Collection $student_club;

    public function __construct()
    {
        $this->student_club = new ArrayCollection();
    }



    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function getNSC(): ?int
    {
        return $this->NSC;
    }

    public function setNSC(int $NSC): self
    {
        $this->NSC = $NSC;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Club>
     */
    public function getStudentClub(): Collection
    {
        return $this->student_club;
    }

    public function addStudentClub(Club $studentClub): self
    {
        if (!$this->student_club->contains($studentClub)) {
            $this->student_club->add($studentClub);
        }

        return $this;
    }

    public function removeStudentClub(Club $studentClub): self
    {
        $this->student_club->removeElement($studentClub);

        return $this;
    }


}
