<?php

namespace ck\RecipesBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use ck\RecipesBundle\Entity\Ingredient;

class IngredientsToStringTransformer implements DataTransformerInterface
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
     * Transforms an object (ingredient) to a string
     *
     * @param  ingredient|null $ingredient
     * @return string
     */
    public function transform($ingredients)
    {
        $this->collection = $ingredients;
        
        if (null === $ingredients || empty($ingredients) || !isset($ingredients->id)) {
            return;
        }
        
        $ingredientsList = array();

        foreach ($ingredients as $ingredient)
        {
            $ingredientsList[] = $ingredient->getId();
        }

        if(sizeof($ingredientsList) > 0)
            return implode(",", $ingredientsList);

        return $ingredientsList;
    }

    /**
     * Transforms a string (ids) to an object (ingredient).
     *
     * @param  string $ids
     * @return ingredient|null
     * @throws TransformationFailedException if object (ingredient) is not found.
     */
    public function reverseTransform($ids)
    {
        if (!$ids) {
            return null;
        }

        if(preg_match("/,/", $ids))
            $ingredients = $this->om->getRepository('ckRecipesBundle:Ingredient')->findBy(array('id' => explode(",", $ids)));
        elseif($this->is_multiple)
            $ingredients = $this->om->getRepository('ckRecipesBundle:Ingredient')->findBy(array('id' => $ids));
        else
            $ingredients = $this->om->getRepository('ckRecipesBundle:Ingredient')->find($ids);

        if (null === $ingredients) {
            throw new TransformationFailedException(sprintf(
                'Recipes #%s can\' be found',
                $ids
            ));
        }

        // for many to many relations
        if($this->is_multiple && !is_null($this->collection))
        {
            // Process diff with bindings changes
            if(!is_array($ingredients))
                $ingredients = array($ingredients);

            // Transforms array into arrayCollection
            $col = new ArrayCollection();

            foreach ($ingredients as $u)
            {
                $col->add($u);
            }

            // Add ingredient if doesn't exist in collection
            foreach ($ingredients as $u)
            {
                if(!$this->collection->contains($u))
                    $this->collection->add($u);
            }

            // Remove ingredient if no longer present
            foreach ($this->collection as $past_u)
            {
                if(!$col->contains($past_u))
                    $this->collection->removeElement($past_u);
            }

            return $this->collection;
        }

        return $ingredients;
    }
}