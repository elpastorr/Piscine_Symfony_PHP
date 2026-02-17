<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('table/index.html.twig');
    }

    #[Route('/create-table', name: 'create_table')]
    public function createTable(Connection $connection): Response
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT NOT NULL,
                username VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                enable BOOLEAN NOT NULL,
                birthdate DATETIME NOT NULL,
                address LONGTEXT NOT NULL,
                PRIMARY KEY(id),
                UNIQUE INDEX UNIQ_USERNAME (username),
                UNIQUE INDEX UNIQ_EMAIL (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        try {
            $connection->executeStatement($sql);
            $this->addFlash('success', 'Table created successfully or already exists.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->redirectToRoute('home');
    }
}