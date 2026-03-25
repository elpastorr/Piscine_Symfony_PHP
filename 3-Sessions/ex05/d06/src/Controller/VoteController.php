<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Vote;
use App\Repository\VoteRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VoteController extends AbstractController
{
    #[Route('/post/{id}/vote/{value}', name: 'post_vote')]
    public function vote(Post $post, int $value, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        foreach ($post->getVotes() as $vote) {
            if ($vote->getUser() === $user) {
                $this->addFlash('error', 'You already voted!');
                return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
            }
        }

        $vote = new Vote();
        $vote->setUser($user);
        $vote->setPost($post);
        $vote->setValue($value);

        $em->persist($vote);
        $em->flush();

        return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
    }
}