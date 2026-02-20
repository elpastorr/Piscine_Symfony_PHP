<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class TableController extends AbstractController
{
    #[Route('/ex02', name: 'ex02')]
    #[Route('/ex02/', name: 'ex02_slash')]
    public function index(Request $request, Connection $connection): Response
    {
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
                username VARCHAR(255) UNIQUE NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                enable BOOLEAN NOT NULL DEFAULT 0,
                birthdate DATETIME NOT NULL,
                address LONGTEXT  NOT NULL
            )
        ");

        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('enable', CheckboxType::class, ['required' => false])
            ->add('birthdate', DateTimeType::class)
            ->add('address', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $enable = isset($data['enable']) && $data['enable'] ? 1 : 0;

            $connection->executeStatement("
                INSERT INTO users
                (username, name, email, enable, birthdate, address)
                VALUES (?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE username = username
            ", [
                $data['username'],
                $data['name'],
                $data['email'],
                $enable,
                $data['birthdate']->format('Y-m-d H:i:s'),
                $data['address']
            ]);
        }

        $users = $connection->fetchAllAssociative("SELECT * FROM users");

        return $this->render('ex02/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users
        ]);
    }
}