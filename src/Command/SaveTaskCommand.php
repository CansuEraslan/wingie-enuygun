<?php

namespace App\Command;

use App\Service\TaskManagerService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SaveTaskCommand extends Command
{
    /** @var TaskManagerService $taskManagerService */
    public $taskManagerService;

    /** @var string */
    protected static $defaultName = 'SaveTaskCommand';

    /**
     * SaveTaskCommand constructor.
     * @param string|null $name
     */
    public function __construct(TaskManagerService $taskManagerService, string $name = null)
    {
        $this->taskManagerService = $taskManagerService;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Save Tasks Command')
            ->setHelp('This command allows you to save task');
    }

    /**
     * @throws ORMException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws OptimisticLockException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->taskManagerService->initialize();
        $output->writeln(['Task Save']);
        return Command::SUCCESS;
    }
}
