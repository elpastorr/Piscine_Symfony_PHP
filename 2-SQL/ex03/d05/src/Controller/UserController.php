<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/ex03', name: 'ex03')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Fetch all users
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existing = $em->getRepository(User::class)->findOneBy([
                'username' => $user->getUsername(),
            ]);

            if (!$existing) {
                $em->persist($user);
                $em->flush();
            }

            return $this->redirectToRoute('ex03');
        }

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users
        ]);
    }
}