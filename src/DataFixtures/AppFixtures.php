<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profile;
use App\Entity\Project;
use App\Entity\Technology;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer un administrateur
        $admin = new User();
        $admin->setFirstname('admin')
              ->setLastname('admin')
              ->setEmail('admin@admin.com');

        // Encoder le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($hashedPassword);

        // Définir le rôle de l'administrateur
        $admin->setRoles(['ROLE_ADMIN']);

        // profile
        $profile = new Profile();
        $profile->setBio('Administrateur du site.')
                ->setAvatar('assets/admin.jpg');

        $admin->setProfile($profile);

        // Créer un utilisateur
        $user = new User();
        $user->setFirstname('John')
             ->setLastname('Doe')
             ->setEmail('john.doe@example.com');

        // Encoder le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
        $user->setPassword($hashedPassword);

        // Créer un profil pour l'utilisateur
        $profile = new Profile();
        $profile->setBio('Développeur Symfony passionné.')
                ->setAvatar('assets/user.jpg');

        $user->setProfile($profile);

        // Créer des projets pour l'utilisateur
        $project1 = new Project();
        $project1->setTitle('Projet A')
                 ->setDescription('Description du projet A.')
                 ->setCreatedAt(new \DateTime())
                 ->setUser($user);

        $project2 = new Project();
        $project2->setTitle('Projet B')
                 ->setDescription('Description du projet B.')
                 ->setCreatedAt(new \DateTime())
                 ->setUser($user);

        // Créer des technologies
        $technology1 = new Technology();
        $technology1->setName('Symfony')
                    ->setLogo('assets/Symfony.png')
                    ->setVersion('5.4');

        $technology2 = new Technology();
        $technology2->setName('MySQL')
                    ->setLogo('assets/MySQL.png')
                    ->setVersion('8.0');

        $technology3 = new Technology();
        $technology3->setName('Docker')
                    ->setLogo('assets/Docker.png')
                    ->setVersion('20.10');

        $technology4 = new Technology();
        $technology4->setName('React')
                    ->setLogo('assets/React.png')
                    ->setVersion('17.0');

        $technology5 = new Technology();
        $technology5->setName('Node.js')
                    ->setLogo('assets/Nodejs.png')
                    ->setVersion('14.17');

        $technology6 = new Technology();
        $technology6->setName('MongoDB')
                    ->setLogo('assets/MongoDB.png')
                    ->setVersion('4.4');

        $technology7 = new Technology();
        $technology7->setName('Vue.js')
                    ->setLogo('assets/Vuejs.png')
                    ->setVersion('3.0');

        $technology8 = new Technology();
        $technology8->setName('Angular')
                    ->setLogo('assets/Angular.png')
                    ->setVersion('12.0');

        $technology9 = new Technology();
        $technology9->setName('Java')
                    ->setLogo('assets/Java.png')
                    ->setVersion('11');

        $technology10 = new Technology();
        $technology10->setName('C')
                    ->setLogo('assets/C.png')
                    ->setVersion('11');

        $technology11 = new Technology();
        $technology11->setName('C++')
                    ->setLogo('assets/C++.png')
                    ->setVersion('11');

        $technology12 = new Technology();
        $technology12->setName('Python')
                    ->setLogo('assets/Python.png')
                    ->setVersion('11');

        $technology13 = new Technology();
        $technology13->setName('PHP')
                    ->setLogo('assets/PHP.png')
                    ->setVersion('11');

        // Associer des technologies aux projets
        $project1->addTechnology($technology1);
        $project1->addTechnology($technology2);

        $project2->addTechnology($technology2);
        $project2->addTechnology($technology3);

        // Persister toutes les entités
        $manager->persist($user);
        $manager->persist($profile);
        $manager->persist($project1);
        $manager->persist($project2);
        $manager->persist($technology1);
        $manager->persist($technology2);
        $manager->persist($technology3);
        $manager->persist($technology4);
        $manager->persist($technology5);
        $manager->persist($technology6);
        $manager->persist($technology7);
        $manager->persist($technology8);
        $manager->persist($technology9);
        $manager->persist($technology10);
        $manager->persist($technology11);
        $manager->persist($technology12);
        $manager->persist($technology13);
        $manager->persist($admin);

        // Sauvegarder les données dans la base
        $manager->flush();
    }
}
