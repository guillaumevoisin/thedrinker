<?php

namespace ck\RecipesBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use ck\RecipesBundle\Entity\RecipesCategory;

class RecipesCategoriesToStringTransformer implements DataTransformerInterface
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
     * Transforms an object (recipe category) to a string
     *
     * @param  recipe category|null $recipe category
     * @return string
     */
    public function transform($recipesCategories)
    {
        $this->collection = $recipesCategories;

        if (null === $recipesCategories) {
            return "";
        }

        $recipesCategoriesList = array();

        foreach ($recipesCategories as $recipeCategory)
        {
            $recipesCategoriesList[] = $recipeCategory->getId();
        }

        if(sizeof($recipesCategoriesList) > 0)
            return implode(",", $recipesCategoriesList);

        return $recipesCategoriesList;
    }

    /**
     * Transforms a string (ids) to an object (recipe category).
     *
     * @param  string $ids
     * @return recipe category|null
     * @throws TransformationFailedException if object (recipe category) is not found.
     */
    public function reverseTransform($ids)
    {
        if (!$ids) {
            return null;
        }

        if(preg_match("/,/", $ids))
            $recipesCategories = $this->om->getRepository('ckRecipesBundle:RecipesCategory')->findBy(array('id' => explode(",", $ids)));
        elseif($this->is_multiple)
            $recipesCategories = $this->om->getRepository('ckRecipesBundle:RecipesCategory')->findBy(array('id' => $ids));
        else
            $recipesCategories = $this->om->getRepository('ckRecipesBundle:RecipesCategory')->find($ids);

        if (null === $recipesCategories) {
            throw new TransformationFailedException(sprintf(
                'Recipes #%s can\' be found',
                $ids
            ));
        }

        // for many to many relations
        if($this->is_multiple && !is_null($this->collection))
        {
            // Process diff with bindings changes
            if(!is_array($recipesCategories))
                $recipesCategories = array($recipesCategories);

            // Transforms array into arrayCollection
            $col = new ArrayCollection();

            foreach ($recipesCategories as $u)
            {
                $col->add($u);
            }

            // Add recipe category if doesn't exist in collection
            foreach ($recipesCategories as $u)
            {
                if(!$this->collection->contains($u))
                    $this->collection->add($u);
            }

            // Remove recipe category if no longer present
            foreach ($this->collection as $past_u)
            {
                if(!$col->contains($past_u))
                    $this->collection->removeElement($past_u);
            }

            return $this->collection;
        }

        return $recipesCategories;
    }
}