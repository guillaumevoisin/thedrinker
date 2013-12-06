<?php
namespace ck\RecipesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use ck\RecipesBundle\Entity\RecipesIngredients as RecipesIngredients;
use ck\RecipesBundle\Entity\Ingredient as Ingredient;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Accessor;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes")
 * @ORM\HasLifecycleCallbacks
 * @ExclusionPolicy("all") 
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Expose
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     * @Expose
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="text")
     * @Expose
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     * @Accessor(getter="getEmbedPath")
     */
    protected $path;

    /**
     * @Assert\File(maxSize="6000000", mimeTypes={"image/jpeg", "image/png", "image/gif"})
     */
    protected $file;

    /**
     * @ORM\OneToMany(targetEntity="RecipesIngredients", mappedBy="recipe", cascade={"persist", "remove"}, orphanRemoval=true)
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
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $glassType;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $preparationType;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $whereToDrink;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $creator;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $garnish;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Expose
     */
    protected $difficulty;

    /**
     * @var User $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="\ck\UsersBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @var User $updatedBy
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="\ck\UsersBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    private $updatedBy;

    /**
     * @var User $contentChangedBy
     *
     * @Gedmo\Blameable(on="change", field={"name"})
     * @ORM\ManyToOne(targetEntity="\ck\UsersBundle\Entity\User")
     * @ORM\JoinColumn(name="content_changed_by", referencedColumnName="id")
     */
    private $contentChangedBy;

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
     * Set difficulty
     *
     * @param string $difficulty
     * @return Recipe
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    
        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string 
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Recipe
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return Recipe
     */
    public function setFile($file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add ingredients
     *
     * @param RecipesIngredients $recipesIngredients
     * @return Recipe
     */
    public function addIngredient(RecipesIngredients $recipesIngredients)
    {
        $this->ingredients[] = $recipesIngredients;
    
        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param RecipesIngredients $recipesIngredients
     */
    public function removeIngredient(RecipesIngredients $recipesIngredients)
    {
        $this->ingredients->removeElement($recipesIngredients);
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
     * Set categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
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
     * Set tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
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

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return Entity
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     * @return Entity
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    
        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set contentChangedBy
     *
     * @param string $contentChangedBy
     * @return Entity
     */
    public function setContentChangedBy($contentChangedBy)
    {
        $this->contentChangedBy = $contentChangedBy;
    
        return $this;
    }

    /**
     * Get contentChangedBy
     *
     * @return string 
     */
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    public function getEmbedPath()
    {
        return '../' . $this->getWebPath();
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = $this->slug.'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}