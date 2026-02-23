<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class E08Controller extends AbstractController
{
    #[Route('/ex08', name: 'ex08')]
    public function index(): Response
    {
        return $this->render('ex08/index.html.twig');
    }

    #[Route('/ex08/edit-persons', name: 'ex08_edit_persons')]
    public function editPersons(Connection $connection): Response
    {
        try {
            $connection->executeStatement("
                ALTER TABLE persons
                ADD COLUMN  IF NOT EXISTS marital_status
                ENUM('single', 'married', 'widower') DEFAULT 'single'
            ");
            $message = "Column marital_status added successfully";
        } catch (\Exception $e) {
            $message = "Error editing persons table";
        }

        return $this->render('ex08/result.html.twig', [
            'message' => $message
        ]);
    }

    #[Route('/ex08/create-persons', name: 'ex08_create_persons')]
    public function createPersons(Connection $connection): Response
    {
        try {
            $connection->executeStatement("
                CREATE TABLE IF NOT EXISTS persons ( 
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255),
                    name VARCHAR(255),
                    email VARCHAR(255),
                    enable BOOLEAN,
                    birthdate DATETIME
                ) ENGINE=InnoDB
            ");
            $message = "Persons table created successfully";
        } catch (\Exception $e) {
            $message = "Error creating persons table";
        }

        return $this->render('ex08/result.html.twig', [
            'message' => $message
        ]);
    }

    #[Route('/ex08/create-relations', name: 'ex08_create_relations')]
    public function createRelations(Connection $connection): Response
    {
        try {
            // One to one
            $connection->executeStatement("
                CREATE TABLE IF NOT EXISTS bank_accounts ( 
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    account_number VARCHAR(255),
                    person_id INT UNIQUE,
                    FOREIGN KEY (person_id) REFERENCES persons(id)
                    ON DELETE CASCADE
                )
            ");

            // One to many
            $connection->executeStatement("
                CREATE TABLE IF NOT EXISTS addresses ( 
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    street VARCHAR(255),
                    city VARCHAR(255),
                    person_id INT,
                    FOREIGN KEY (person_id) REFERENCES persons(id)
                    ON DELETE CASCADE
                )
            ");
            $message = "Relations created successfully";
        } catch (\Exception $e) {
            $message = "Error creating relations";
        }

        return $this->render('ex08/result.html.twig', [
            'message' => $message
        ]);
    }
}