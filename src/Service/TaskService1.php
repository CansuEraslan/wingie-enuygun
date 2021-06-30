<?php

namespace App\Service;

use App\Entity\Task;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TaskService1
{
    const API_URL = "http://www.mocky.io/v2/5d47f24c330000623fa3ebfa";

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function sendRequest(): array
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
                ->setTitle($task['id'])
                ->setEstimatedDuration($task['sure'])
                ->setLevel($task['zorluk']);
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
    public function saveTasks():array
    {
        return $this->sendRequest();
    }

}