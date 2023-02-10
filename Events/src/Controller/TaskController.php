<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TaskRepository;
use App\Entity\Task;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function index(TaskRepository $taskRepository): Response
    {


        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $taskRepository->findAll()

        ]);
    }

    #[Route('/{id}/edit/{state_request}', name: 'app_task_edit_State_request', methods: ['GET', 'POST'])]
    public function editState_request(Request $request, int $state_request, Task $task, TaskRepository $taskRepository): Response
    {



        //El estado 1 es Aceptado
        //El estado 0 es Rechazado

        $task->setStateRequest($state_request);

        $taskRepository->save($task, true);

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);



    }

    #[Route('/{id}/updateState/{state}', name: 'app_task_update_State', methods: ['GET', 'POST'])]
    public function UpdateState(Request $request, Task $task, TaskRepository $taskRepository): Response
    {

        //En state 1 es Asignado
        //En state NULL es no asignado
        
        $breakTime=$request->get("breakHours");

        $task->setBreakTime($breakTime);


        // $task->setState($state);


        if($state==1){
            $fecha= new \DateTime();
            $task->setStartTime($fecha);        

            
        }else{

            $fecha= new \DateTime();
            $task->setEndTime($fecha);
            
            $state_request=2;
        }

        // $task->setStateRequest($state_request);
        $taskRepository->save($task, true);



        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        
    

    }
}