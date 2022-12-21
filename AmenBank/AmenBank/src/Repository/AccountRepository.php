<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Account $entity, bool $flush = true): void
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
    public function remove(Account $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function MyAccounts($userid)
    {
        return $this->createQueryBuilder('acc')
            ->innerJoin('acc.User','u')
            ->andWhere('u.id = :id')    // or = : for precise
            ->setParameter('id', $userid)
            ->getQuery()
            ->execute();
    }

    public function SearchNumber($number)
    {
        return $this->createQueryBuilder('acc')
            ->andWhere('acc.number LIKE :number')     // or =: for precise
            ->setParameter('number', '%'.$number.'%')
            ->getQuery()
            ->execute();
    }
    public function SearchUserFromAccount($user)
    {
        return $this->createQueryBuilder('acc')
            ->innerJoin('acc.User','u')
            ->andWhere('u.username LIKE :username')    // or = : for precise
            ->setParameter('username', '%'.$user.'%')
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Account[] Returns an array of Account objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Account
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
