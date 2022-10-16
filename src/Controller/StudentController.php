<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return new Response("Bonjour mes étudiants");
    }
    #[Route('/students', name: 'app_students')]
    public function listStudent(StudentRepository $repository)
    {
        $students = $repository->findAll();
        return $this->render("student/listStudent.html.twig", array("tabStudents" => $students));
    }
    #[Route('/AddStudent', name: 'app_AddStudent')]
    public function AddStudent(ManagerRegistry $doctrine, Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("app_students");
        }
        return $this->renderForm("student/addStudent.html.twig", array("formStudent" => $form));
    }
    #[Route('/updateStudent/{NSC}', name: 'app_updateStudent')]
    public function updateStudent(StudentRepository $repository, $NSC, ManagerRegistry $doctrine, Request $request)
    {
        $student = $repository->find($NSC);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();

            $em->flush();
            return $this->redirectToRoute("app_students");
        }

        return $this->renderForm("student/updateStudent.html.twig", array("formStudent" => $form));
    }
    #[Route('/removeStudent/{NSC}', name: 'app_removeStudent')]

    public function deleteStudent(ManagerRegistry $doctrine, $NSC, StudentRepository $repository)
    {
        $student = $repository->find($NSC);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("app_students");
    }
}
