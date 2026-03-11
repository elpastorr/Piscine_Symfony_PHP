<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class E10Controller extends AbstractController
{
    #[Route('/ex10/import', name: 'ex10_import')]
    public function import(Connection $connection, EntityManagerInterface $em): Response
    {
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS users_sql (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255),
                name VARCHAR(255),
                email VARCHAR(255),
                enable BOOLEAN,
                birthdate DATETIME,
                marital_status VARCHAR(20)
            )
        ");

        $file = __DIR__ . '/../../data/users.csv';

        if (!file_exists($file)) {
            return new Response("File not found");
        }

        $lines = file($file);
        array_shift($lines); // remove header

        foreach ($lines as $line) {

            $data = str_getcsv($line);

            [$username, $name, $email, $enable, $birthdate, $maritalStatus] = $data;

            // SQL
            $connection->executeStatement(
                "INSERT INTO users_sql (username,name,email,enable,birthdate,marital_status)
                 VALUES (?,?,?,?,?,?)",
                [$username,$name,$email,$enable,$birthdate,$maritalStatus]
            );

            // ORM
            $user = new User();
            $user->setUsername($username);
            $user->setName($name);
            $user->setEmail($email);
            $user->setEnable((bool)$enable);
            $user->setBirthdate(new \DateTime($birthdate));
            $user->setMaritalStatus($maritalStatus);

            $em->persist($user);
        }

        $em->flush();

        return new Response("Users imported successfully");
    }

    #[Route('/ex10/users', name: 'ex10_users')]
    public function users(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('ex10/users.html.twig', [
            'users' => $users
        ]);
    }
}