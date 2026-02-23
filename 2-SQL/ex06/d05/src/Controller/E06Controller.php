<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class E06Controller extends AbstractController
{
    #[Route('/ex06', name: 'ex06')]
    public function index(Connection $connection): Response
    {
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS ex06_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255),
                name VARCHAR(255),
                email VARCHAR(255),
                enable BOOLEAN,
                birthdate DATETIME,
                address TEXT
            )
        ");

        $users = $connection->fetchAllAssociative(
            "SELECT * FROM ex06_users"
        );

        return $this->render('ex06/index.html.twig', [
            'users' => $users,
            'message' => null
        ]);
    }

    #[Route('/ex06/edit/{id}', name: 'ex06_edit')]
    public function edit(int $id, Request $request, Connection $connection): Response
    {
        $user = $connection->fetchAssociative(
            "SELECT * FROM ex06_users WHERE id = ?",
            [$id]
        );

        if (!$user) {
            return $this->redirectToRoute('ex06');
        }

        if ($request->isMethod('POST')) {
            $connection->executeStatement("
                UPDATE ex06_users
                SET username = ?, name = ?, email = ?, enable = ?, birthdate = ?, address = ?
                WHERE id = ?
            ", [
                $request->request->get('username'),
                $request->request->get('name'),
                $request->request->get('email'),
                $request->request->get('enable') ? 1 : 0,
                $request->request->get('birthdate'),
                $request->request->get('address'),
                $id
            ]);

            return $this->redirectToRoute('ex06');
        }
        return $this->render('ex06/edit.html.twig', [
            'user' => $user
        ]);
    }

    // FOR TESTING
    #[Route('/ex06/create-test', name: 'ex06_create_test')]
    public function createTestUsers(Connection $connection): Response
    {
        $connection->executeStatement("
            INSERT INTO ex06_users 
            (username, name, email, enable, birthdate, address)
            VALUES 
            ('jean', 'Jean Pate', 'JP@oui.com', 1, '1990-01-01 00:00:00', '1 rue Jean'),
            ('jeanne', 'Jeanne Smith', 'jeanne@oui.com', 0, '2000-10-10 00:00:00', '2 rue Jeanne'),
            ('bob', 'Bob ibrown', 'bob@oui.com', 1, '1995-12-31 00:00:00', '3 rue Bob')
        ");

        return new Response('Test users created!');
    }
}