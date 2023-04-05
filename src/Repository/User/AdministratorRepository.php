<?php

namespace App\Repository\User;

use App\Entity\User\Administrator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Administrator>
 *
 * @method Administrator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Administrator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Administrator[]    findAll()
 * @method Administrator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdministratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Administrator::class);
    }

    public function save(Administrator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Administrator $entity, bool $flush = false): void
    {
        $entity
            ->setEmail($entity->getEmail() . '-deletedAt-' . (new \DateTime())->format('Ymd_His'))
            ->setDeletedAt(new \DateTimeImmutable());

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Used to ensure email is unique across all User and inherited classes
    public function findUserByEmail($criteria)
    {
        return $this
            ->getEntityManager()
            ->createQuery("SELECT u FROM App\Entity\User u WHERE u.email = :email")
            ->setParameters($criteria)
            ->getResult();
    }

//    /**
//     * @return Administrator[] Returns an array of Administrator objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Administrator
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
