<?php
namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


public function findUpcomingAndValidated(?string $category = null): array
{
    $qb = $this->createQueryBuilder('e')
        
        ->where('e.validated = :validated')
        ->andWhere('e.date >= :now')
        ->setParameter('validated', true)
        ->setParameter('now', new \DateTime())
        ->orderBy('e.date', 'ASC');

    if ($category) {
        $qb->andWhere('e.category = :category')
           ->setParameter('category', $category);
    }

    return $qb->getQuery()->getResult();
}

}