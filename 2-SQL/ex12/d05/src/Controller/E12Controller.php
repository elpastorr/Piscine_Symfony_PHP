<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class E12Controller extends AbstractController
{
    #[Route('/ex12', name: 'ex12')]
    public function index(PersonRepository $personRepo): Response
    {
        $persons = $personRepo->findWithAccountsAndAddresses();

        return $this->render('ex12/index.html.twig', [
            'persons' => $persons,
        ]);
    }
}