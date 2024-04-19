<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Doctrine\ORM\EntityManagerInterface; // Import EntityManagerInterface
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

#[Route('/api', name: 'api_')]
class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index', methods:['get'] )]
    public function index(): JsonResponse
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();
    
        $data = [];
    
        foreach ($products as $product) {
           $data[] = [
               'id' => $users->getId(),
               'firstName' => $users->getFirstName(),
               'lastName' => $users->getLastName(),
               'email' => $users->getEmail(),
           ];
        }
        return $this->json($data);
    }
    #[Route('/users', name: 'user_create', methods:['post'] )]
    public function create(EntityManagerInterface $entityManager, MessageBusInterface $bus, Request $request): JsonResponse
    {
        $user = new User();
        $user->setFirstName($request->get('firstName'));
        $user->setLastName($request->get('lastName'));
        $user->setEmail($request->get('email'));
    
        $entityManager->persist($user);
        $entityManager->flush();
    
        
        $data =  [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
        ];
        $bus->dispatch($data);

        return $this->json($data);
    }
}
