<?php

namespace App\Controller;

use App\Entity\E07User;
use App\Form\E07UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class E07Controller extends AbstractController
{
    #[Route('/ex07', name: 'ex07')]
    public function index(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(E07User::class)->findAll();

        return $this->render('ex07/index.html.twig', [
            'users' => $users,
            'message' => null
        ]);
    }

    #[Route('/ex07/edit/{id}', name: 'ex07_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(E07User::class)->find($id);

        if (!$user) {
            return $this->redirectToRoute('ex07', [
                'message' => 'User not found'
            ]);
        }

        $form = $this->createForm(E07UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            return $this->redirectToRoute('ex07', [
                'message' => 'User updated successfully'
            ]);
        }

        return $this->render('ex07/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ex07/create-test', name: 'ex07_create_test')]
    public function createTest(EntityManagerInterface $em): Response
    {
        $user = new E07User();
        $user->setUsername('test');
        $user->setName('Test User');
        $user->setEmail('test@test.com');
        $user->setEnable(true);
        $user->setBirthdate(new \DateTime());
        $user->setAddress('Test Address');

        $em->persist($user);
        $em->flush();

        return new Response('Created!');
    }
}