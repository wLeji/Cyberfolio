<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function list(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs depuis le UserRepository
        $users = $userRepository->findAll();

        // Retourner une vue Twig avec la liste des utilisateurs
        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function show(UserRepository $userRepository, int $id): Response
    {
        // Récupérer un utilisateur par son ID
        $user = $userRepository->find($id);
    
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }
    
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}