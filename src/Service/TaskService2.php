<?php

namespace App\Service;

use App\Entity\Task;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TaskService2
{
    const API_URL = "http://www.mocky.io/v2/5d47f235330000623fa3ebf7";

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendRequest(): array
    {
        $request = HttpClient::create();
        $data = $request->request("GET", self::API_URL)->toArray();
        return $this->parseData($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function parseData(array $data): array
    {
        $tasks = [];
        foreach ($data as $task) {
            $tasks[] = (new Task())
                ->setTitle(array_keys($task)[0])
                ->setEstimatedDuration($task[array_keys($task)[0]]['estimated_duration'])
                ->setLevel($task[array_keys($task)[0]]['level']);
        }
        return $tasks;
    }

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function saveTasks(): array
    {
        return $this->sendRequest();

    }
}