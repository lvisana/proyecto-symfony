<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tasks;
use App\Repository\UserRepository;
use App\Repository\TasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]

    public function task(Tasks $task): Response
    {
        return $this->render('task/single-task.html.twig', [
            'task' => $task
        ]);
    }

    public function index(TasksRepository $tasksRepository): Response
    {
        $tasks = $tasksRepository->findBy([], ['created_at' => 'DESC']);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function create(Request $request, EntityManagerInterface $entityManager, TasksRepository $tasksRepository, $edit = null): Response
    {
        if ($edit) {
            $task = $tasksRepository->find($edit);

            if (!$task || $task->getUser() !== $this->getUser()) {
                return $this->redirectToRoute('home');
            }
            
        } else {
            $task = new Tasks();
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $task->setUser($this->getUser());
            $task->setCreatedAt((new \DateTime('now')));

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirect(
                $this->generateUrl('single_task', ['id' => $task->getId()])
            );
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function userTasks(UserRepository $userRepository, UserInterface $user): Response
    {
        
        $user = $userRepository->find($user->getUserIdentifier());

        $tasks = $user->getTasks();
        
        return $this->render('user/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function delete(Tasks $task, EntityManagerInterface $entityManager): Response
    {
        if ($task && $task->getUser() == $this->getUser()) {
            $entityManager->remove($task);
            $entityManager->flush();
        }
        return $this->redirectToRoute('home');
    }
}
