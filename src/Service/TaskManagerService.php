<?php

namespace App\Service;

use App\Entity\Developer;
use App\Entity\Task;
use App\Repository\DeveloperRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TaskManagerService
{
    /** @var TaskService1 $taskService1 */
    public $taskService1;

    /** @var TaskService2 $taskService2 */
    public $taskService2;

    /** @var TaskRepository $taskRepository */
    public $taskRepository;

    /** @var DeveloperRepository $developerRepository */
    public $developerRepository;

    public function __construct(TaskService1 $taskService1, TaskService2 $taskService2, TaskRepository $taskRepository,DeveloperRepository $developerRepository)
    {
        $this->taskService1=$taskService1;
        $this->taskService2=$taskService2;
        $this->taskRepository=$taskRepository;
        $this->developerRepository=$developerRepository;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function initialize(){
        $taskData1=$this->taskService1->saveTasks();
        $taskData2=$this->taskService2->saveTasks();
        $tasks=array_merge($taskData1,$taskData2);

        /** @var Task $task */
        foreach ($tasks as $task){
            $this->shareTheTasks($task);
            $this->taskRepository->save($task);
        }
    }

    /**
     * @param Task $task
     * @param Developer $developer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function assignDeveloper(Task $task,Developer $developer){
        $this->taskRepository->assignDeveloper($task,$developer);
    }

    /**
     * @param Task $task
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function shareTheTasks(Task $task){
        $developer=$this->developerRepository->shareTheTask($task);
        $this->assignDeveloper($task,$developer);
    }

}