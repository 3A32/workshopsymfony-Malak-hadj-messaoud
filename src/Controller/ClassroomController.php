<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Doctrine\DBAL\Schema\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/classrooms', name: 'app_classrooms')]
    public function listClassroom(ClassroomRepository $repository)
    {
        $classrooms = $repository->findAll();
        return $this->render("classroom/listClassroom.html.twig", array("tabClassrooms" => $classrooms));
    }
    #[Route('/AddClassroom', name: 'app_AddClassroom')]
    public function AddClassroom(ManagerRegistry $doctrine, Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute("app_classrooms");
        }
        return $this->renderForm("classroom/addClassroom.html.twig", array("formClassroom" => $form));
    }
    #[Route('/updateClassroom/{id}',name:'app_updateClassroom')]
    public function updateClassroom(ClassroomRepository $repository,$id,ManagerRegistry $doctrine, Request $request )
    {
        $classroom= $repository->find($id);
        $form=$this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if($form->isSubmitted())
{
    $em=$doctrine->getManager();
    
    $em->flush();
    return $this->redirectToRoute("app_classrooms");
}
       
        return $this->renderForm("classroom/updateClassroom.html.twig",array("formClassroom"=>$form));
    }
    #[Route('/removeClassroom/{id}', name: 'app_removeClassroom')]

    public function deleteClassroom(ManagerRegistry $doctrine,$id,ClassroomRepository $repository)
    {
        $classroom= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute("app_classrooms");

    }
    
}
