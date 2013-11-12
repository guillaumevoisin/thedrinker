<?php
namespace ck\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bind_recipes_ingredients")
 * @ORM\HasLifecycleCallbacks()
 */
class RecipesIngredients
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="ingredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * */
    protected $recipe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipes")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     * */
    protected $ingredient;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $proportion;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $unit;

    /**
     * Set proportion
     *
     * @param string $proportion
     * @return RecipesIngredients
     */
    public function setProportion($proportion)
    {
        $this->proportion = $proportion;
    
        return $this;
    }

    /**
     * Get proportion
     *
     * @return string 
     */
    public function getProportion()
    {
        return $this->proportion;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return RecipesIngredients
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set recipe
     *
     * @param \ck\RecipesBundle\Entity\Recipe $recipe
     * @return RecipesIngredients
     */
    public function setRecipe(\ck\RecipesBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;
    
        return $this;
    }

    /**
     * Get recipe
     *
     * @return \ck\RecipesBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredient
     *
     * @param \ck\RecipesBundle\Entity\Ingredient $ingredient
     * @return RecipesIngredients
     */
    public function setIngredient(\ck\RecipesBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    
        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \ck\RecipesBundle\Entity\Ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    public function __toString()
    {
        return "";
    }
}