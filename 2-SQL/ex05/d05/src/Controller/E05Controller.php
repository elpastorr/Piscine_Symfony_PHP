<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class E05Controller extends AbstractController
{
    #[Route('/ex05', name: 'ex05')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('ex05');
        }

        $users = $em->getRepository(User::class)->findAll();

        return $this->render('ex05/index.html.twig', [
            'users' => $users,
            'message' => null
        ]);
    }

    #[Route('/ex05/delete/{id}', name: 'ex05_delete')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->redirectToRoute('ex05', ['message' => 'User not found']);
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('ex05', ['msg' => 'User deleted successfully']);
    }

    // FOR TESTING
    // #[Route('/ex05/create-users', name: 'ex05_create_test')]
    // public function createTestUsers(EntityManagerInterface $em): Response
    // {
    //     $user1 = new User();
    //     $user1->setUsername('jean-mich');
    //     $user1->setName('oe');
    //     $user1->setEmail('jeanmich@oui.com');
    //     $user1->setEnable(true);
    //     $user1->setBirthdate(new \DateTime('1990-01-01'));
    //     $user1->setAddress('123 rue du four');

    //     $user2 = new User();
    //     $user2->setUsername('jeanne');
    //     $user2->setName('Jeanne calme');
    //     $user2->setEmail('jeanne@oui.com');
    //     $user2->setEnable(false);
    //     $user2->setBirthdate(new \DateTime('2000-12-12'));
    //     $user2->setAddress('456 rue machin');

    //     $em->persist($user1);
    //     $em->persist($user2);
    //     $em->flush();

    //     return new Response('Test users created!');
    // }
}