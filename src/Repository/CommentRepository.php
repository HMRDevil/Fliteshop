<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Comment $entity, bool $flush = true): void
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
    public function remove(Comment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function getQBCommentPager($approved = true, $keywords = null, $type = 'all')
    {
        $qb = $this->createQueryBuilder('comment');
        if($type === Comment::PRODUCT_TYPE || $type === Comment::BLOG_TYPE)
        {
            $qb->where("comment.type = '$type'");
        }
        if($approved)
        {
            $qb->where('comment.approved = true');
        }
        if(isset($keywords))
        {
            $qb->andWhere('comment.text LIKE :keywords')
                    ->setParameter('keywords', "%$keywords%");
        }
        return $qb->orderBy('comment.date', 'DESC');
    }
    
    public function delete(array $ids)
    {
        foreach ($ids as $id)
        {
            $this->_em->createQuery('DELETE App\Entity\Comment comment WHERE comment.id = :id')
                    ->setParameter('id', $id)
                    ->getResult();
            $this->_em->flush();
        }
    }
    
    public function approved(array $ids)
    {
        $this->_em->createQuery('UPDATE App\Entity\Comment comment SET comment.approved = true WHERE comment.id IN (:ids)')
                    ->setParameter('ids', $ids)
                    ->getResult();
        $this->_em->flush();
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
