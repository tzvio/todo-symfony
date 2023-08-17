<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Task;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class IndexController extends AbstractController
{
    private $documentManager;
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }


    #[Route('/task/update/{id}', name: 'task_update', methods: ['PATCH'])]
    public function updateTask(int $id, Request $request) :JsonResponse
    {
        $task = $this->documentManager->getRepository(Task::class)->find($id);
        $data = json_decode($request->getContent(), true);
        if (!$task) {
            return new JsonResponse(['message' => 'Element not found'], 404);
        }
        $task->setDesc($data['desc']);    
        $this->documentManager->persist($task);
        $this->documentManager->flush();

        return new JsonResponse(['message' => 'Element updated successfully']);
    }

    #[Route('/task/delete/{id}', name: 'task_delete', methods: ['DELETE'])]
    public function deleteTaskById(int $id) :JsonResponse
    {
        $task = $this->documentManager->getRepository(Task::class)->find($id);
        if (!$task) {
            return new JsonResponse(['message' => 'Element not found'], 404);
        }

        $this->documentManager->remove($task);
        $this->documentManager->flush();

        return new JsonResponse(['message' => 'Element deleted successfully']);
    }

    #[Route('/', name: 'home_page')]
    public function list(HttpFoundationRequest $request, DocumentManager $dm)
    {

        if ($request->getMethod()=="POST" && $request->get('task-desc')) {
            $task = new Task();
            $task->setDesc($request->get('task-desc'));    
            $this->documentManager->persist($task);
            $this->documentManager->flush();
        }
        $repository = $dm->getRepository(Task::class);
        $tasks = $repository->findAll();
        return $this->render('index/homepage.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    
}
