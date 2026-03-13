<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class E13Controller extends AbstractController
{
    #[Route('/', name: 'employee_list')]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        $employees = $employeeRepository->findAll();
        return $this->render('employee/index.html.twig', ['employees' => $employees]);
    }

    #[Route('/create', name: 'employee_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();
            $this->addFlash('success', 'Employee created successfully');
            return $this->redirectToRoute('employee_list');
        }

        return $this->render('employee/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/edit/{id}', name: 'employee_edit')]
    public function edit(Employee $employee, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Employee updated successfully');
            return $this->redirectToRoute('employee_list');
        }

        return $this->render('employee/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'employee_delete')]
    public function delete(Employee $employee = null, EntityManagerInterface $em): Response
    {
        if (!$employee) {
            $this->addFlash('error', 'Employee not found');
        } else {
            $em->remove($employee);
            $em->flush();
            $this->addFlash('success', 'Employee deleted successfully');
        }

        return $this->redirectToRoute('employee_list');
    }
}