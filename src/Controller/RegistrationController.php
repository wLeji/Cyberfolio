<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profile; // Import de l'entité Profile
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Création d'un profil par défaut pour l'utilisateur
            $profile = new Profile();
            $profile->setBio('Bio par défaut'); // Tu peux personnaliser ce contenu
            $profile->setAvatar('path/to/default/avatar.jpg'); // Chemin vers un avatar par défaut

            // Associe le profil à l'utilisateur
            $user->setProfile($profile);

            // Persistance des données
            $entityManager->persist($profile); // Persist le profil
            $entityManager->persist($user);    // Persist l'utilisateur
            $entityManager->flush();

            // Redirection après inscription
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
