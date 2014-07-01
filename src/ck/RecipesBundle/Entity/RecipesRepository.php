<?php

namespace ck\RecipesBundle\Entity;

use FOS\ElasticaBundle\Repository;

/**
 * RecipesRepository
 */
class RecipesRepository extends Repository
{

    public function filterFind($searchText)
    {
        $query_part = new \Elastica\Query\Bool();

        $filters = new \Elastica\Filter\Bool();

        /*$fieldQuery = new \Elastica\Query\Text();
        $fieldQuery->setFieldQuery('name', $searchText);
        $query_part->addShould($fieldQuery);*/

        // $query_part->addMust(new \Elastica\Query\Term(array('creator' => array('value' => 'Guigui'))));
        // $query_part->addMust(new \Elastica\Query\Term(array('difficulty' => array('value' => 'hard'))));

        /*$ingdtsQuery = new \Elastica\Query\Terms();
        $ingdtsQuery->setTerms('ingredients', array('Yamazaki'));
        $query_part->addMust($ingdtsQuery);*/

        /*$nested = new \Elastica\Query\Nested();
        $nested->setQuery(new \Elastica\Query\Term(array('name' => array('value' => 'Yamazaki'))));
        $nested->setPath('ingredients');
        $query_part->addShould($nested);*/

        $nested = new \Elastica\Query\Nested();
        $nested->setQuery(new \Elastica\Query\Term(array('name' => array('value' => 'plop'))));
        $nested->setPath('tags');
        $query_part->addShould($nested);

        /*$nested = new \Elastica\Query\Nested();
        $nested->setQuery(new \Elastica\Query\Term(array('name' => array('value' => 'Tiki'))));
        $nested->setPath('categories');
        $query_part->addShould($nested);*/

        /*$filters->addMust(
            new \Elastica\Filter\NumericRange('created', array(
                'lte' => date('c'),
            ))
        );*/

        // $query = new \Elastica\Query\Filtered($query_part, $filters);
        return $this->find($query_part);
    }

    /*public function getNbResults()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('count (r)')->from('ck\RecipesBundle\Entity\Recipe', 'r')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }

    public function findLikeName($q, $page, $nb_results, $filter = null)
    {
        $firstResult = ($page-1) * $nb_results;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $result = $qb->select('r')->from('ck\RecipesBundle\Entity\Recipe', 'r')
            ->where( $qb->expr()->like('i.name', $qb->expr()->literal('%' . $q . '%')) );

        $rs = $result
            ->setFirstResult( $firstResult )->setMaxResults( $nb_results )
            ->getQuery()
            ->getResult();

        return $rs;
    }*/
}
