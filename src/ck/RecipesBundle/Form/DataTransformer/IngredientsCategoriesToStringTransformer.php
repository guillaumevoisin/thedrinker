<?php

namespace ck\RecipesBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use ck\RecipesBundle\Entity\IngredientsCategory;

class IngredientsCategoriesToStringTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $is_multiple;
    private $collection;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $is_multiple = true)
    {
        $this->om = $om;
        $this->is_multiple = $is_multiple;
    }

    /**
     * Transforms an object (ingredient category) to a string
     *
     * @param  ingredient category|null $ingredient category
     * @return string
     */
    public function transform($ingredientsCategories)
    {
        $this->collection = $ingredientsCategories;

        if (null === $ingredientsCategories) {
            return "";
        }

        $ingredientsCategoriesList = array();

        foreach ($ingredientsCategories as $ingredientCategory)
        {
            $ingredientsCategoriesList[] = $ingredientCategory->getId();
        }

        if(sizeof($ingredientsCategoriesList) > 0)
            return implode(",", $ingredientsCategoriesList);

        return $ingredientsCategoriesList;
    }

    /**
     * Transforms a string (ids) to an object (ingredient category).
     *
     * @param  string $ids
     * @return ingredient category|null
     * @throws TransformationFailedException if object (ingredient category) is not found.
     */
    public function reverseTransform($ids)
    {
        if (!$ids) {
            return null;
        }

        if(preg_match("/,/", $ids))
            $ingredientsCategories = $this->om->getRepository('ckRecipesBundle:IngredientsCategory')->findBy(array('id' => explode(",", $ids)));
        elseif($this->is_multiple)
            $ingredientsCategories = $this->om->getRepository('ckRecipesBundle:IngredientsCategory')->findBy(array('id' => $ids));
        else
            $ingredientsCategories = $this->om->getRepository('ckRecipesBundle:IngredientsCategory')->find($ids);

        if (null === $ingredientsCategories) {
            throw new TransformationFailedException(sprintf(
                'Recipes #%s can\' be found',
                $ids
            ));
        }

        // for many to many relations
        if($this->is_multiple && !is_null($this->collection))
        {
            // Process diff with bindings changes
            if(!is_array($ingredientsCategories))
                $ingredientsCategories = array($ingredientsCategories);

            // Transforms array into arrayCollection
            $col = new ArrayCollection();

            foreach ($ingredientsCategories as $u)
            {
                $col->add($u);
            }

            // Add ingredient category if doesn't exist in collection
            foreach ($ingredientsCategories as $u)
            {
                if(!$this->collection->contains($u))
                    $this->collection->add($u);
            }

            // Remove ingredient category if no longer present
            foreach ($this->collection as $past_u)
            {
                if(!$col->contains($past_u))
                    $this->collection->removeElement($past_u);
            }

            return $this->collection;
        }

        return $ingredientsCategories;
    }
}