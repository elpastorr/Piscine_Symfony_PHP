<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class E00Controller extends AbstractController
{
    #[Route('/e00', name: 'e00')]
    #[Route('/e00', name: 'e00_slash')]
    public function index(): Response
    {
        
    }
}