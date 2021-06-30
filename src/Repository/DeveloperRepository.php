<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Developer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Developer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Developer[]    findAll()
 * @method Developer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developer::class);
    }

    /**
     * @return array
     */
    public function getAllDevelopers(): array
    {
        return $this->findAll();
    }

    /**
     * @return Developer|object|null
     */
    public function getNonAssignDevelopers()
    {
        return $this->findOneBy([], ['time' => 'ASC']);
    }

    /**
     * @param Task $task
     * @return Developer|object|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function shareTheTask(Task $task)
    {
        $developer = $this->getNonAssignDevelopers();
        $developer->setTime(
            $developer->getTime() + ($task->getCalculatingTheDifficulty() / $developer->getDifficulty())
        );
        $this->getEntityManager()->persist($developer);
        $this->getEntityManager()->flush();
        return $developer;
    }
}
