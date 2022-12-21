<?php

namespace App\Repository;

use App\Entity\Virement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Virement>
 *
 * @method Virement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Virement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Virement[]    findAll()
 * @method Virement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VirementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Virement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Virement $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Virement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function MesVirements($userid)
    {
        return $this->createQueryBuilder('vir')
            ->innerJoin('vir.Account','acc')
            ->innerJoin('vir.Account_2','acc2')
            ->andWhere('acc.User = :id or acc2.User = :id')    // or = : for precise
            ->setParameter('id', $userid)
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Virement[] Returns an array of Virement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Virement
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
