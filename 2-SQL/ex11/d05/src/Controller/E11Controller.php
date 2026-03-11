<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class E11Controller extends AbstractController
{
    #[Route('/ex11', name: 'ex11')]
    public function index(Connection $connection): Response
    {
        $users = $connection->fetchAllAssociative("
            SELECT p.id, p.username, p.name, p.birthdate,
                   b.account_number,
                   a.city
            FROM persons p
            JOIN bank_accounts b ON p.id = b.person_id
            JOIN addresses a ON p.id = a.person_id
            ORDER BY p.name ASC
        ");

        return $this->render('ex11/index.html.twig', [
            'users' => $users
        ]);
    }
}