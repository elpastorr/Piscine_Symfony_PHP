<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class E04Controller extends AbstractController
{
    #[Route('/ex04', name: 'ex04')]
    public function index(Request $request, Connection $connection): Response
    {
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS ex04_table (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT
            )
        ");

        if ($request->query->get('title')) {
            $connection->executeStatement(
                "INSERT INTO ex04_table (title, description) VALUES (?, ?)",
                [$request->query->get('title'), $request->query->get('description')]
            );
        }

        $message = $request->query->get('msg', null);

        $items = $connection->fetchAllAssociative("SELECT * FROM ex04_table");

        return $this->render('ex04/index.html.twig', [
            'items' => $items,
            'message' => $message
        ]);
    }

    #[Route('/ex04/delete/{id}', name: 'ex04_delete')]
    public function delete(int $id, Connection $connection): Response
    {
        $item = $connection->fetchAssociative("SELECT * FROM ex04_table WHERE id = ?", [$id]);

        if (!$item) {
            return $this->redirectToRoute('ex04', ['msg' => 'Item not found']);
        }

        $connection->executeStatement("DELETE FROM ex04_table WHERE id = ?", [$id]);

        return $this->redirectToRoute('ex04', ['msg' => 'Item deleted successfully']);
    }
}