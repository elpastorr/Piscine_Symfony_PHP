<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use App\Entity\User;

class TableController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('table/index.html.twig');
    }

    #[Route('/create-table', name: 'create_table')]
    public function createTable(EntityManagerInterface $em): Response
    {
        try {
            $metadata = $em->getClassMetadata(User::class);
            $schemaTool = new SchemaTool($em);

            $schemaTool->updateSchema([$metadata], true);

            $this->addFlash('success', 'Table created successfully or already exists.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->redirectToRoute('home');
    }
}