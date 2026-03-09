<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class E09Controller extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function test(EntityManagerInterface $em): Response
    {
        $persons = $em->getRepository(Person::class)->findAll();
        return $this->render('person/test.html.twig', [
            'persons' => $persons,
        ]);
    }

    #[Route('/person/new', name: 'person_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($person);
            $em->flush();

            $this->addFlash('success', 'Person created successfully!');

            return $this->redirectToRoute('test');
        }

        return $this->render('person/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}