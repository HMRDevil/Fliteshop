<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use App\Traits;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    use Traits\VisibilityTrait;
    use Traits\DeletionTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
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
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function getSearchProductsInnerJoinVariants($keywords = null)
    {
        return $this->_em->createQuery('SELECT p, v, i
                FROM App\Entity\Product p
                INNER JOIN p.variant v
                INNER JOIN p.image i
                WHERE p.id = v.product
                AND p.id = i.product
                AND p.name LIKE :keywords OR p.metaKeywords LIKE :keywords
                ORDER BY p.created DESC')
                ->setParameter('keywords', "%$keywords%");
    }
    
    public function innerJoinVariantsForProducts()
    {
        return $this->_em->createQuery('SELECT p, v, i
                FROM App\Entity\Product p
                INNER JOIN p.variant v
                INNER JOIN p.image i
                WHERE p.id = v.product
                AND p.id = i.product
                ORDER BY p.created DESC');
    }
    
    public function productsForCategory(array $ids)
    {
        return $this->_em->createQuery('SELECT p, v, i
                FROM App\Entity\Product p
                INNER JOIN p.variant v
                INNER JOIN p.image i
                INNER JOIN App\Entity\ProductCategories pc WITH pc.product = p.id AND pc.category in(:ids)
                LEFT JOIN p.brand b WITH p.brand = b.id
                WHERE p.visible=1
                GROUP BY p.id, v.id, i.id
                ORDER BY p.position DESC
                ')
                ->setParameter('ids', $ids);
    }
    
    public function productsForCategoryAndBrand(array $categoriesId, int $brandId)
    {
        return $this->_em->createQuery('SELECT p, v, i
                FROM App\Entity\Product p
                INNER JOIN p.variant v
                INNER JOIN p.image i
                INNER JOIN App\Entity\ProductCategories pc WITH pc.product = p.id AND pc.category in(:categoriesId)
                LEFT JOIN p.brand b WITH p.brand = b.id
                WHERE p.brand in(:brandId)
                AND p.visible=1
                GROUP BY p.id, v.id, i.id
                ORDER BY p.position DESC
                ')
                ->setParameter('categoriesId', $categoriesId)
                ->setParameter('brandId', $brandId);
    }
    
    public function productsForBrand(int $brandId)
    {
        return $this->_em->createQuery('SELECT p, v, i
                FROM App\Entity\Product p
                INNER JOIN p.variant v
                INNER JOIN p.image i
                LEFT JOIN p.brand b WITH p.brand = b.id
                WHERE p.brand in(:brandId)
                AND p.visible=1
                GROUP BY p.id, v.id, i.id
                ORDER BY p.position DESC
                ')
                ->setParameter('brandId', $brandId);
    }
    
    public function count(array $categoriesId)
    {
        $value = $this->_em->createQuery('SELECT count(distinct p.id) as count
				FROM App\Entity\Product p
				INNER JOIN App\Entity\ProductCategories pc WITH pc.product = p.id AND pc.category in(:categoriesId)
				WHERE p.visible=1')
                ->setParameter('categoriesId', $categoriesId)
                ->getResult();
        return $value[0]['count'];
    }
    
    public function recommended(int $max = 24)
    {
        return $this->_em->createQuery('SELECT p
                FROM App\Entity\Product p
                WHERE p.featured = true
                ORDER BY p.created ASC')
                ->setMaxResults($max)
                ->getResult();
    }
    
    public function thing(int $max = 3)
    {
        return $this->_em->createQuery('SELECT p
                FROM App\Entity\Product p
                ORDER BY p.created DESC')
                ->setMaxResults($max)
                ->getResult();
    }
    
    public function stock(int $max = 3)
    {
        return $this->_em->createQuery('SELECT p
            FROM App\Entity\Product p
            WHERE EXISTS
            (SELECT 1 FROM
            App\Entity\Variant pv
            WHERE pv.product=p AND pv.comparePrice>0) ORDER BY p.position DESC')
                ->setMaxResults($max)
                ->getResult();
    }
    
    public function getQBProductPager($keywords = null, $fullVisible = false)
    {
        $qb = $this->createQueryBuilder('p');
        if(!$fullVisible)
        {
            $qb->where('p.visible = true');
        }
        if(isset($keywords))
        {
            $qb->andWhere('p.name LIKE :keywords OR p.metaKeywords LIKE :keywords')
                    ->setParameter('keywords', "%$keywords%");
        }
        return $qb->orderBy('p.position', 'DESC');
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
