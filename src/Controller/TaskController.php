<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tasks;
use App\Repository\TasksRepository;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(TasksRepository $tasksRepository): Response
    {
        $tasks = $tasksRepository->findAll();

        foreach ($tasks as $task) {
            $userName = $task->getUser()->getName();
            var_dump($userName);
            echo '<br>';
            echo '<br>';
        }

die();
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
