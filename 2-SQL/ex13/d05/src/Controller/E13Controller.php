<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class E13Controller extends AbstractController
{
    // #[Route('/ex13', name: 'ex13')]
    // public function index(Request $request, Connection $connection): Response
    // {
    //     $sql = "
    //         SELECT p.id, p.username, p.name, p.birthdate,
    //                b.account_number,
    //                a.city
    //         FROM person p
    //         JOIN bank_account b ON p.id = b.person_id
    //         JOIN address a ON p.id = a.person_id
    //     ";

    //     $params = [];
    //     $conditions = [];

    //     if ($request->query->get('date')) {
    //         $conditions[] = "p.birthdate >= ?";
    //         $params[] = $request->query->get('date');
    //     }

    //     if (count($conditions) > 0) {
    //         $sql .= " WHERE " . implode(" AND ", $conditions);
    //     }

    //     $sort = $request->query->get('sort');
    //     if (in_array($sort, ['name', 'birthdate'])) {
    //         $sql .= " ORDER BY p.$sort ASC";
    //     }

    //     $persons = $connection->fetchAllAssociative($sql, $params);

    //     return $this->render('ex11/index.html.twig', [
    //         'persons' => $persons
    //     ]);
    // }

    #[Route('/employee', name: 'employee_list')]
    public function index(EntityManagerInterface $em): Response
    {
        $employees = $em->getRepository(Employee::class)->findAll();
        return $this->render('employee/index.html.twig', [
            'employees' => $employees,
        ]);
    }

    #[Route('/employee/create', name:'employee_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($employee);
            $em->flush();

            $this->addFlash('success', 'Employee created!');
            return $this->redirectToRoute('employee_list');
        }

        return $this->render('employee/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}