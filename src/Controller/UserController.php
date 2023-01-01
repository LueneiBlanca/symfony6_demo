<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // Create user test
    #[Route('/user/create', name: 'create_user')]
    public function createUser(PersistenceManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setName('Test user for demo');
        $user->setEmail('test@demosymfony.com');
        $user->setStatus(User::STATUS_ACTIVE);
        $user->setAddress('Demo Avenue');
        
        // validate before persist
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(PersistenceManagerRegistry $doctrine, int $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return new Response('Check out this great user: '.$user->getName());

        // return $this->render('user/show.html.twig', ['user' => $user]);
    }
}
