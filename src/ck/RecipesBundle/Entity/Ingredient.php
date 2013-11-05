<?php
namespace ck\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ingredients")
 */
class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $volume;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $alcoholVolume;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $age;

    /**
     * @ORM\ManyToMany(targetEntity="IngredientsCategory", inversedBy="ingredients")
     * @ORM\JoinTable(name="bind_ingredients_categories",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="RecipesIngredients", mappedBy="ingredient", cascade={"all"})
     * */

    protected $recipes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Ingredient
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ingredient
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add categories
     *
     * @param \ck\RecipesBundle\Entity\IngredientsCategory $categories
     * @return Ingredient
     */
    public function addCategorie(\ck\RecipesBundle\Entity\IngredientsCategory $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \ck\RecipesBundle\Entity\IngredientsCategory $categories
     */
    public function removeCategorie(\ck\RecipesBundle\Entity\IngredientsCategory $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set volume
     *
     * @param string $volume
     * @return Ingredient
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    
        return $this;
    }

    /**
     * Get volume
     *
     * @return string 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set alcoholVolume
     *
     * @param string $alcoholVolume
     * @return Ingredient
     */
    public function setAlcoholVolume($alcoholVolume)
    {
        $this->alcoholVolume = $alcoholVolume;
    
        return $this;
    }

    /**
     * Get alcoholVolume
     *
     * @return string 
     */
    public function getAlcoholVolume()
    {
        return $this->alcoholVolume;
    }

    /**
     * Set age
     *
     * @param string $age
     * @return Ingredient
     */
    public function setAge($age)
    {
        $this->age = $age;
    
        return $this;
    }

    /**
     * Get age
     *
     * @return string 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Add recipes
     *
     * @param \ck\RecipesBundle\Entity\RecipesIngredients $recipes
     * @return Ingredient
     */
    public function addRecipe(\ck\RecipesBundle\Entity\RecipesIngredients $recipes)
    {
        $this->recipes[] = $recipes;
    
        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \ck\RecipesBundle\Entity\RecipesIngredients $recipes
     */
    public function removeRecipe(\ck\RecipesBundle\Entity\RecipesIngredients $recipes)
    {
        $this->recipes->removeElement($recipes);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}