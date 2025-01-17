<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

#[Route('/project')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'app_project_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager
            ->getRepository(Project::class)
            ->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/new', name: 'project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload du fichier screenshot
            $screenshotFile = $form->get('screenshot')->getData();
            if ($screenshotFile) {
                $newFilename = uniqid().'.'.$screenshotFile->guessExtension();

                // Déplacer le fichier vers le répertoire configuré
                $screenshotFile->move(
                    $this->getParameter('uploads_directory'), // Configuré dans services.yaml
                    $newFilename
                );

                // Mettre à jour l'entité avec le chemin du fichier
                $project->setScreenshot('uploads/'.$newFilename);
            }

            // Associer l'utilisateur connecté au projet
            $project->setUser($this->getUser());

            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', 'Projet créé avec succès !');

            return $this->redirectToRoute('app_project_index');
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        // Vérifie que l'utilisateur connecté est bien le propriétaire du projet ou un administrateur
        if ($this->getUser() !== $project->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException('Vous ne pouvez pas modifier ce projet.');
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $screenshotFile = $form->get('screenshot')->getData();
            if ($screenshotFile) {
                $newFilename = uniqid() . '.' . $screenshotFile->guessExtension();
                $screenshotFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
                $project->setScreenshot('uploads/' . $newFilename);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Projet modifié avec succès !');

            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        // Vérifie que l'utilisateur connecté est bien le propriétaire du projet ou un administrateur
        if ($this->getUser() !== $project->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException('Vous ne pouvez pas supprimer ce projet.');
        }

        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();

            $this->addFlash('success', 'Projet supprimé avec succès !');
        }

        // Redirige vers la liste des projets ou la page utilisateur
        return $this->redirectToRoute('app_project_index');
    }
}
