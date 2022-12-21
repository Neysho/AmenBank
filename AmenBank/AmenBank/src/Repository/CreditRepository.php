<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 *
 * @method Credit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Credit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Credit[]    findAll()
 * @method Credit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Credit $entity, bool $flush = true): void
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
    public function remove(Credit $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function SearchUserFromCredit($user)
    {
        return $this->createQueryBuilder('cr')
            ->innerJoin('cr.User','u')
            ->andWhere('u.username LIKE :username')    // or = : for precise
            ->setParameter('username', '%'.$user.'%')
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Credit[] Returns an array of Credit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Credit
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
