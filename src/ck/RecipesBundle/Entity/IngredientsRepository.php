<?php

namespace ck\RecipesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IngredientsRepository
 */
class IngredientsRepository extends EntityRepository
{
    public function getNbResults()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('count (i)')->from('ck\RecipesBundle\Entity\Ingredient', 'i')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }

    public function findLikeName($q, $page, $nb_results, $filter = null)
    {
        $firstResult = ($page-1) * $nb_results;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('i')->from('ck\RecipesBundle\Entity\Ingredient', 'i')
            ->where( $qb->expr()->like('i.name', $qb->expr()->literal('%' . $q . '%')) );

        $rs = $result
            ->setFirstResult( $firstResult )->setMaxResults( $nb_results )
            ->getQuery()
            ->getResult();

        return $rs;
    }
}
