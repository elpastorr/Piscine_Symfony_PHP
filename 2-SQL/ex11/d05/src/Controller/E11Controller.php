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
            CREATE TABLE person (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255),
                name VARCHAR(255),
                email VARCHAR(255),
                birthdate DATETIME
        ";
        $sort = $request->query->get('sort');

        if (!in_array($sort, ['name', 'birthdate', null])) {
            $sort = null;
        }

        if ($sort === 'name') {
            $sql .= " ORDER BY p.name ASC";
        } elseif ($sort === 'birthdate') {
            $sql .= " ORDER BY p.birthdate ASC";
        }

        $person = $connection->fetchAllAssociative($sql);

        return $this->render('ex11/index.html.twig', [
            'person' => $person
        ]);
    }
}