<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Connection;

class HackedController extends AbstractController
{
    #[Route('/inject', name: 'sql_inject')]
    public function inject(Connection $connection): Response
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS hacked_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255),
                password VARCHAR(255)
            )
        ";

        $connection->executeStatement($sql);

        $tables = $connection->executeQuery("SHOW TABLES LIKE 'hacked_users'")->fetchAllAssociative();

        return $this->render('inject/index.html.twig', [
            'table_exists' => count($tables) > 0
        ]);
    }

    #[Route('/inject/save', name: 'sql_inject_save', methods: ['POST'])]
    public function save(Request $request, Connection $connection): Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $sql = "INSERT INTO hacked_users (username, password) VALUES ('$username', '$password')";

        $connection->executeStatement($sql);

        return $this->redirectToRoute('sql_inject_list');
    }

    #[Route('/inject/list', name: 'sql_inject_list')]
    public function list(Connection $connection): Response
    {
        $data = $connection->executeQuery("SELECT * FROM hacked_users")->fetchAllAssociative();
    
        return $this->render('inject/list.html.twig', [
            'data' => $data
        ]);
    }
}

