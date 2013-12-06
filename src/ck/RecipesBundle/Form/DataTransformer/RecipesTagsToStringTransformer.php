<?php

namespace ck\RecipesBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use ck\RecipesBundle\Entity\RecipesTag;

class RecipesTagsToStringTransformer implements DataTransformerInterface
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
    public function transform($recipesTags)
    {
        $this->collection = $recipesTags;

        if (null === $recipesTags) {
            return "";
        }

        $recipesTagsList = array();

        foreach ($recipesTags as $recipeCategory)
        {
            $recipesTagsList[] = $recipeCategory->getId();
        }

        if(sizeof($recipesTagsList) > 0)
            return implode(",", $recipesTagsList);

        return $recipesTagsList;
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

        $idsList = array();

        // Create new entities
        if(preg_match("/,/", $ids))
        {
            $tmp = explode(",", $ids);
            foreach ($tmp as $value)
            {
                if(!is_numeric($value))
                {
                    $newTag = new RecipesTag();
                    $newTag->setName($value);

                    $this->om->persist($newTag);
                    $this->om->flush();

                    $idsList[] = $newTag->getId();
                }
                else
                    $idsList[] = $value;
            }
        }
        else
        {
            if(!is_numeric($ids))
            {
                $newTag = new RecipesTag();
                $newTag->setName($ids);

                $this->om->persist($newTag);
                $this->om->flush();

                $idsList[] = $newTag->getId();
            }
            else
                $idsList[] = $ids;
        }

        $ids = implode(",", $idsList);

        if(preg_match("/,/", $ids))
            $recipesTags = $this->om->getRepository('ckRecipesBundle:RecipesTag')->findBy(array('id' => explode(",", $ids)));
        elseif($this->is_multiple)
            $recipesTags = $this->om->getRepository('ckRecipesBundle:RecipesTag')->findBy(array('id' => $ids));
        else
            $recipesTags = $this->om->getRepository('ckRecipesBundle:RecipesTag')->find($ids);

        if (null === $recipesTags) {
            throw new TransformationFailedException(sprintf(
                'Recipes #%s can\' be found',
                $ids
            ));
        }

        // for many to many relations
        if($this->is_multiple && !is_null($this->collection))
        {
            // Process diff with bindings changes
            if(!is_array($recipesTags))
                $recipesTags = array($recipesTags);

            // Transforms array into arrayCollection
            $col = new ArrayCollection();

            foreach ($recipesTags as $u)
            {
                $col->add($u);
            }

            // Add recipe category if doesn't exist in collection
            foreach ($recipesTags as $u)
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

        return $recipesTags;
    }
}