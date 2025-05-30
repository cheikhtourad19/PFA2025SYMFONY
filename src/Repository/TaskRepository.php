<?php
// src/Repository/TaskRepository.php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Medecin;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Trouve les tâches assignées à un médecin
     */


    public function findTasksForMedecin(Medecin $medecin): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assignedTo = :medecin OR t.createdBy = :medecin')
            ->setParameter('medecin', $medecin)
            ->getQuery()
            ->getResult();
    }


    public function findByAssignedMedecin(Medecin $medecin): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assignedTo = :medecin')
            ->setParameter('medecin', $medecin)
            ->getQuery()
            ->getResult();
    }
    public function findByAssignedMedecinAndCreator(Medecin $assignedTo, Medecin $createdBy): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assignedTo = :assignedTo')
            ->andWhere('t.createdBy = :createdBy')
            ->setParameter('assignedTo', $assignedTo)
            ->setParameter('createdBy', $createdBy)
            ->getQuery()
            ->getResult();
    }




    public function findFollowedTasks(Medecin $user)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.createdBy = :user')
            ->setParameter('user', $user)
            ->orderBy('t.deadline', 'ASC')
            ->getQuery()
            ->getResult();
    }
}