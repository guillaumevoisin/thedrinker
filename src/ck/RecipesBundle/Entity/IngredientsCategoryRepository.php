<?php

namespace ck\RecipesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IngredientsCategoryRepository
 */
class IngredientsCategoryRepository extends EntityRepository
{
    public function getNbResults()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('count (c)')->from('ck\RecipesBundle\Entity\IngredientsCategory', 'c')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }

    public function findLikeName($q, $page, $nb_results, $filter = null)
    {
        $firstResult = ($page-1) * $nb_results;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('c')->from('ck\RecipesBundle\Entity\IngredientsCategory', 'c')
            ->where( $qb->expr()->like('c.name', $qb->expr()->literal('%' . $q . '%')) );

        $rs = $result
            ->setFirstResult( $firstResult )->setMaxResults( $nb_results )
            ->getQuery()
            ->getResult();

        return $rs;
    }
}
