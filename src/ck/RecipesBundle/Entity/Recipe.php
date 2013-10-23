<?php
namespace ck\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes")
 */
class Recipe
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="RecipesIngredients", mappedBy="recipe", cascade={"all"})
     * */

    protected $ingredients;

    /**
     * @ORM\ManyToMany(targetEntity="RecipesCategory", inversedBy="recipes")
     * @ORM\JoinTable(name="bind_recipes_categories",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="RecipesTag", inversedBy="recipes")
     * @ORM\JoinTable(name="bind_recipes_tags",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $glassType;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $preparationType;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $whereToDrink;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $creator;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $garnish;

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
     * @return Recipe
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
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Recipe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Recipe
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
     * Set glassType
     *
     * @param string $glassType
     * @return Recipe
     */
    public function setGlassType($glassType)
    {
        $this->glassType = $glassType;
    
        return $this;
    }

    /**
     * Get glassType
     *
     * @return string 
     */
    public function getGlassType()
    {
        return $this->glassType;
    }

    /**
     * Set preparationType
     *
     * @param string $preparationType
     * @return Recipe
     */
    public function setPreparationType($preparationType)
    {
        $this->preparationType = $preparationType;
    
        return $this;
    }

    /**
     * Get preparationType
     *
     * @return string 
     */
    public function getPreparationType()
    {
        return $this->preparationType;
    }

    /**
     * Set whereToDrink
     *
     * @param string $whereToDrink
     * @return Recipe
     */
    public function setWhereToDrink($whereToDrink)
    {
        $this->whereToDrink = $whereToDrink;
    
        return $this;
    }

    /**
     * Get whereToDrink
     *
     * @return string 
     */
    public function getWhereToDrink()
    {
        return $this->whereToDrink;
    }

    /**
     * Set creator
     *
     * @param string $creator
     * @return Recipe
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return string 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set garnish
     *
     * @param string $garnish
     * @return Recipe
     */
    public function setGarnish($garnish)
    {
        $this->garnish = $garnish;
    
        return $this;
    }

    /**
     * Get garnish
     *
     * @return string 
     */
    public function getGarnish()
    {
        return $this->garnish;
    }

    /**
     * Add ingredients
     *
     * @param \ck\RecipesBundle\Entity\Ingredient $ingredients
     * @return Recipe
     */
    public function addIngredient(\ck\RecipesBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;
    
        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \ck\RecipesBundle\Entity\Ingredient $ingredients
     */
    public function removeIngredient(\ck\RecipesBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Add categories
     *
     * @param \ck\RecipesBundle\Entity\RecipesCategory $categories
     * @return Recipe
     */
    public function addCategorie(\ck\RecipesBundle\Entity\RecipesCategory $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \ck\RecipesBundle\Entity\RecipesCategory $categories
     */
    public function removeCategorie(\ck\RecipesBundle\Entity\RecipesCategory $categories)
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

    /**
     * Add tags
     *
     * @param \ck\RecipesBundle\Entity\RecipesTag $tags
     * @return Recipe
     */
    public function addTag(\ck\RecipesBundle\Entity\RecipesTag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param \ck\RecipesBundle\Entity\RecipesTag $tags
     */
    public function removeTag(\ck\RecipesBundle\Entity\RecipesTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Recipe
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Recipe
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}