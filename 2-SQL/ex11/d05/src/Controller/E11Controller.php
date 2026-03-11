<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class E11Controller extends AbstractController
{
    #[Route('/ex11', name: 'ex11')]
    public function index(Request $request, Connection $connection): Response
    {
        $sql = "
            SELECT p.id, p.username, p.name, p.birthdate,
                   b.account_number,
                   a.city
            FROM person p
            JOIN bank_account b ON p.id = b.person_id
            JOIN address a ON p.id = a.person_id
        ";

        $params = [];
        $conditions = [];

        if ($request->query->get('date')) {
            $conditions[] = "p.birthdate >= ?";
            $params[] = $request->query->get('date');
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sort = $request->query->get('sort');
        if (in_array($sort, ['name', 'birthdate'])) {
            $sql .= " ORDER BY p.$sort ASC";
        }

        $persons = $connection->fetchAllAssociative($sql, $params);

        return $this->render('ex11/index.html.twig', [
            'persons' => $persons
        ]);
    }

    #[Route('/ex11/quick-create', name: 'ex11_quick_create')]
    public function quickCreate(Connection $connection): Response
    {
        $rnum = rand(100, 999);
        $username = 'user' . $rnum;
        $name = 'User' . $rnum;
        $email = 'user' . $rnum . '@test.com';
        $birthdate = date('Y-m-d', strtotime('-' . rand(18, 60) . ' years'));

        $connection->executeStatement("
            INSERT INTO person (username, name, email, birthdate, enable, marital_status)
            VALUES (?, ?, ?, ?, ?, ?)
        ", [
            $username,
            $name,
            $email,
            $birthdate,
            rand(0, 1),
            'single'
        ]);

        $personId = $connection->lastInsertId();

        $accountNumber = 'ACC' . rand(10000,99999);

        $connection->executeStatement("
            INSERT INTO bank_account (person_id, account_number)
            VALUES (?, ?)
        ", [
            $personId,
            $accountNumber,
        ]);

        $city = 'Test City';
        $street = rand(1, 999) . ' Test Street';

        $connection->executeStatement("
            INSERT INTO address (person_id, city, street)
            VALUES (?, ?, ?)
        ", [
            $personId,
            $city,
            $street
        ]);

        return new Response("Person '$username' created successfully!");
    }
}