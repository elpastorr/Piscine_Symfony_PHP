<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function loginAction(EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_post_index');
        }

        $posts = $em->getRepository(Post::class)->findBy([], ['created' => 'DESC']);

        return $this->render('user/login.html.twig', [
            'posts'      => $posts,
        ]);
    }
}